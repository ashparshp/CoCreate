<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    public function index(Project $project): View
    {
        // Manual authorization check
        $user = Auth::user();
        if (!$project->is_public && !$project->members->contains($user)) {
            abort(403, 'Unauthorized action.');
        }
        
        $tasks = $project->tasks()->with(['assignedUser', 'creator'])->get();
        
        return view('tasks.index', compact('project', 'tasks'));
    }

    public function create(Project $project): View
    {
        // Manual authorization check
        $user = Auth::user();
        $membership = $project->members()
            ->where('user_id', $user->id)
            ->wherePivotIn('role', ['owner', 'member'])
            ->first();
            
        if (!$membership) {
            abort(403, 'Unauthorized action.');
        }
        
        $members = $project->members;
        
        return view('tasks.create', compact('project', 'members'));
    }

    public function store(Request $request, Project $project): RedirectResponse
    {
        // Manual authorization check
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
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:to_do,in_progress,review,completed',
        ]);

        $task = new Task($request->all());
        $task->project_id = $project->id;
        $task->created_by = Auth::id();
        $task->save();

        return redirect()->route('projects.tasks.index', $project)
            ->with('success', 'Task created successfully.');
    }

    public function show(Project $project, Task $task): View
    {
        // Manual authorization check
        $user = Auth::user();
        if (!$project->is_public && !$project->members->contains($user)) {
            abort(403, 'Unauthorized action.');
        }
        
        // Ensure task belongs to this project
        if ($task->project_id !== $project->id) {
            abort(404);
        }
        
        $task->load(['assignedUser', 'creator', 'comments.user', 'files']);
        
        return view('tasks.show', compact('project', 'task'));
    }

    public function edit(Project $project, Task $task): View
    {
        // Manual authorization check
        $user = Auth::user();
        $membership = $project->members()
            ->where('user_id', $user->id)
            ->wherePivotIn('role', ['owner', 'member'])
            ->first();
            
        if (!$membership) {
            abort(403, 'Unauthorized action.');
        }
        
        // Ensure task belongs to this project
        if ($task->project_id !== $project->id) {
            abort(404);
        }
        
        $members = $project->members;
        
        return view('tasks.edit', compact('project', 'task', 'members'));
    }

    public function update(Request $request, Project $project, Task $task): RedirectResponse
    {
        // Manual authorization check
        $user = Auth::user();
        $membership = $project->members()
            ->where('user_id', $user->id)
            ->wherePivotIn('role', ['owner', 'member'])
            ->first();
            
        if (!$membership) {
            abort(403, 'Unauthorized action.');
        }
        
        // Ensure task belongs to this project
        if ($task->project_id !== $project->id) {
            abort(404);
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:to_do,in_progress,review,completed',
        ]);

        $task->update($request->all());

        return redirect()->route('projects.tasks.show', [$project, $task])
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Project $project, Task $task): RedirectResponse
    {
        // Manual authorization check
        $user = Auth::user();
        $membership = $project->members()
            ->where('user_id', $user->id)
            ->wherePivotIn('role', ['owner', 'member'])
            ->first();
            
        if (!$membership) {
            abort(403, 'Unauthorized action.');
        }
        
        // Ensure task belongs to this project
        if ($task->project_id !== $project->id) {
            abort(404);
        }
        
        $task->delete();

        return redirect()->route('projects.tasks.index', $project)
            ->with('success', 'Task deleted successfully.');
    }
}
