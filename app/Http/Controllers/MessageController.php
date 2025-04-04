<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    public function index(Project $project): View
    {
        // Manual authorization check
        $user = Auth::user();
        if (!$project->is_public && !$project->members->contains($user)) {
            abort(403, 'Unauthorized action.');
        }
        
        $messages = $project->messages()->with('sender')->latest()->paginate(15);
        
        return view('messages.index', compact('project', 'messages'));
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
            'content' => 'required|string',
        ]);

        $message = new Message([
            'content' => $request->content,
            'sender_id' => Auth::id(),
            'project_id' => $project->id,
        ]);
        
        $message->save();

        // In a real app, you might broadcast this message through a websocket

        return redirect()->route('projects.messages.index', $project)
            ->with('success', 'Message sent successfully.');
    }

    public function destroy(Project $project, Message $message): RedirectResponse
    {
        // Only allow deletion of own messages or by project owner
        if (Auth::id() !== $message->sender_id && Auth::id() !== $project->creator_id) {
            abort(403);
        }
        
        // Ensure message belongs to this project
        if ($message->project_id !== $project->id) {
            abort(404);
        }
        
        $message->delete();

        return back()->with('success', 'Message deleted successfully.');
    }
}
