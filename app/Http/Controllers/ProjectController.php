<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $myProjects = $user->projects()->with('creator')->get();
        $publicProjects = Project::where('is_public', true)
            ->whereNotIn('id', $myProjects->pluck('id'))
            ->with('creator')
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
        
        return view('projects.show', compact('project', 'members', 'pendingMembers'));
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

        // In a real app, you would send an email notification here

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
}
