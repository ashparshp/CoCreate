<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $projects = $user->projects()->with('creator')->get();
        $tasks = $user->assignedTasks()->with('project')->latest()->take(5)->get();
        $pendingInvitations = $user->projects()
            ->wherePivot('role', 'pending')
            ->with('creator')
            ->get();
        
        return view('dashboard', compact('projects', 'tasks', 'pendingInvitations'));
    }
}
