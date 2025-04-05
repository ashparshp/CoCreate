<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\JoinRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectJoinRequest;
use App\Mail\ProjectJoinRequestApproved;

class ProjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $myProjects = $user->projects()->with('creator')->get();
        $publicProjects = Project::where('is_public', true)
            ->whereNotIn('id', $myProjects->pluck('id'))
            ->with(['creator', 'joinRequests' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->get();
        
        return view('projects.index', compact('myProjects', 'publicProjects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_public' => 'boolean',
            'requires_approval' => 'boolean',
        ]);

        $project = new Project($request->all());
        $project->creator_id = Auth::id();
        $project->save();

        // Add creator as project owner
        $project->members()->attach(Auth::id(), ['role' => 'owner']);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        // Instead of using authorize, check manually
        $user = Auth::user();
        if (!$project->is_public && !$project->members->contains($user)) {
            abort(403, 'Unauthorized action.');
        }
        
        $project->load(['creator', 'members', 'tasks', 'files', 'messages']);
        $members = $project->members;
        $pendingMembers = $project->members()->wherePivot('role', 'pending')->get();
        $joinRequests = $project->joinRequests()->with('user')->get();
        
        // Check if current user has a pending join request
        $userJoinRequest = $project->joinRequests()->where('user_id', $user->id)->first();
        
        return view('projects.show', compact('project', 'members', 'pendingMembers', 'joinRequests', 'userJoinRequest'));
    }

    public function edit(Project $project)
    {
        // Instead of using authorize, check manually
        $user = Auth::user();
        $membership = $project->members()
            ->where('user_id', $user->id)
            ->wherePivotIn('role', ['owner', 'member'])
            ->first();
            
        if (!$membership) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        // Instead of using authorize, check manually
        $user = Auth::user();
        $membership = $project->members()
            ->where('user_id', $user->id)
            ->wherePivotIn('role', ['owner', 'member'])
            ->first();
            
        if (!$membership) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:planning,in_progress,completed,on_hold',
            'is_public' => 'boolean',
            'requires_approval' => 'boolean',
        ]);

        $project->update($request->all());

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        // Instead of using authorize, check manually
        $user = Auth::user();
        if ($user->id !== $project->creator_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    public function invite(Request $request, Project $project)
    {
        // Instead of using authorize, check manually
        $user = Auth::user();
        $membership = $project->members()
            ->where('user_id', $user->id)
            ->wherePivotIn('role', ['owner', 'member'])
            ->first();
            
        if (!$membership) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $invitedUser = User::where('email', $request->email)->first();

        // Check if already a member
        if ($project->members()->where('user_id', $invitedUser->id)->exists()) {
            return back()->with('error', 'User is already invited to this project.');
        }

        $project->members()->attach($invitedUser->id, ['role' => 'pending']);

        // Send email notification
        try {
            Mail::to($invitedUser->email)->send(new \App\Mail\ProjectInvitation($project, $user));
        } catch (\Exception $e) {
            // Continue even if email fails
            report($e);
        }

        return back()->with('success', 'Invitation sent successfully.');
    }

    public function acceptInvite(Project $project)
    {
        $membership = $project->members()->where('user_id', Auth::id())->wherePivot('role', 'pending')->first();
        
        if (!$membership) {
            return redirect()->route('dashboard')->with('error', 'Invalid invitation.');
        }

        $project->members()->updateExistingPivot(Auth::id(), ['role' => 'member']);

        return redirect()->route('projects.show', $project)
            ->with('success', 'You have joined the project.');
    }

    public function declineInvite(Project $project)
    {
        $project->members()->detach(Auth::id());

        return redirect()->route('dashboard')
            ->with('success', 'Invitation declined.');
    }

    public function removeMember(Project $project, User $user)
    {
        // Instead of using authorize, check manually
        $currentUser = Auth::user();
        $membership = $project->members()
            ->where('user_id', $currentUser->id)
            ->wherePivotIn('role', ['owner', 'member'])
            ->first();
            
        if (!$membership) {
            abort(403, 'Unauthorized action.');
        }
        
        // Cannot remove the creator
        if ($user->id === $project->creator_id) {
            return back()->with('error', 'Cannot remove the project creator.');
        }

        $project->members()->detach($user->id);

        return back()->with('success', 'Member removed successfully.');
    }
    
    public function requestJoin(Request $request, Project $project)
    {
        // Check if project is public
        if (!$project->is_public) {
            return back()->with('error', 'This project is not open for join requests.');
        }
        
        // Check if user is already a member
        if ($project->members->contains(Auth::id())) {
            return back()->with('error', 'You are already a member of this project.');
        }
        
        // Check if user already has a pending request
        if ($project->joinRequests()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'You already have a pending join request for this project.');
        }
        
        $request->validate([
            'message' => 'nullable|string|max:500',
        ]);
        
        // Create join request
        $joinRequest = $project->joinRequests()->create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'status' => 'pending'
        ]);
        
        // Notify project owner
        try {
            Mail::to($project->creator->email)->send(new ProjectJoinRequest($joinRequest));
        } catch (\Exception $e) {
            // Continue even if email fails
            report($e);
        }
        
        return back()->with('success', 'Join request submitted successfully. You will be notified when it is reviewed.');
    }
    
    public function approveJoinRequest(Project $project, $requestId)
    {
        // Ensure user is project owner or admin
        if (Auth::id() !== $project->creator_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $joinRequest = $project->joinRequests()->findOrFail($requestId);
        
        // Update request status
        $joinRequest->update(['status' => 'approved']);
        
        // Add user to project
        $project->members()->attach($joinRequest->user_id, ['role' => 'member']);
        
        // Notify user
        try {
            Mail::to($joinRequest->user->email)->send(new ProjectJoinRequestApproved($project));
        } catch (\Exception $e) {
            // Continue even if email fails
            report($e);
        }
        
        return back()->with('success', 'Join request approved. User has been added to the project.');
    }
    
    public function rejectJoinRequest(Project $project, $requestId)
    {
        // Ensure user is project owner or admin
        if (Auth::id() !== $project->creator_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $joinRequest = $project->joinRequests()->findOrFail($requestId);
        
        // Update request status
        $joinRequest->update(['status' => 'rejected']);
        
        // Notify user
        try {
            Mail::to($joinRequest->user->email)->send(new \App\Mail\ProjectJoinRequestRejected($project));
        } catch (\Exception $e) {
            // Continue even if email fails
            report($e);
        }
        
        return back()->with('success', 'Join request rejected.');
    }
    
    public function cancelJoinRequest(Project $project)
    {
        $joinRequest = $project->joinRequests()->where('user_id', Auth::id())->first();
        
        if (!$joinRequest) {
            return back()->with('error', 'No join request found.');
        }
        
        $joinRequest->delete();
        
        return back()->with('success', 'Join request cancelled.');
    }
}