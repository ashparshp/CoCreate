<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Project $project, Task $task = null)
    {
        $this->authorize('view', $project);
        
        // Ensure task belongs to this project if provided
        if ($task && $task->project_id !== $project->id) {
            abort(404);
        }
        
        $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = new Comment([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'task_id' => $task ? $task->id : null,
            'project_id' => $task ? null : $project->id,
            'parent_id' => $request->parent_id,
        ]);
        
        $comment->save();

        $redirectRoute = $task 
            ? route('projects.tasks.show', [$project, $task]) 
            : route('projects.show', $project);
        
        return redirect($redirectRoute)
            ->with('success', 'Comment added successfully.');
    }

    public function update(Request $request, Project $project, Comment $comment)
    {
        // Only allow editing of own comments
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }
        
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment->content = $request->content;
        $comment->save();

        return back()->with('success', 'Comment updated successfully.');
    }

    public function destroy(Project $project, Comment $comment)
    {
        // Only allow deletion of own comments or by project owner
        if (Auth::id() !== $comment->user_id && Auth::id() !== $project->creator_id) {
            abort(403);
        }
        
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
