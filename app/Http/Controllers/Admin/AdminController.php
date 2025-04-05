<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Skill;
use App\Models\File;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalProjects = Project::count();
        $totalTasks = Task::count();
        $totalSkills = Skill::count();
        $totalFiles = File::count();
        
        $recentUsers = User::latest()->take(5)->get();
        $recentProjects = Project::with('creator')->latest()->take(5)->get();
        
        $projectsByStatus = [
            'planning' => Project::where('status', 'planning')->count(),
            'in_progress' => Project::where('status', 'in_progress')->count(),
            'completed' => Project::where('status', 'completed')->count(),
            'on_hold' => Project::where('status', 'on_hold')->count(),
        ];
        
        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalProjects', 
            'totalTasks', 
            'totalSkills',
            'totalFiles',
            'recentUsers',
            'recentProjects',
            'projectsByStatus'
        ));
    }
    
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }
    
    public function showUser(User $user)
    {
        $user->load(['skills', 'projects', 'createdProjects', 'assignedTasks']);
        return view('admin.users.show', compact('user'));
    }
    
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'bio' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);
        
        $user->update($request->all());
        
        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully.');
    }
    
    public function projects()
    {
        $projects = Project::with('creator')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }
    
    public function showProject(Project $project)
    {
        $project->load(['creator', 'members', 'tasks', 'files', 'messages']);
        return view('admin.projects.show', compact('project'));
    }
    
    public function deleteProject(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
    
    public function skills()
    {
        $skills = Skill::orderBy('category')->orderBy('name')->paginate(20);
        return view('admin.skills.index', compact('skills'));
    }
    
    public function createSkill()
    {
        return view('admin.skills.create');
    }
    
    public function storeSkill(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skills',
            'category' => 'nullable|string|max:255',
        ]);
        
        Skill::create($request->all());
        
        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill created successfully.');
    }
    
    public function editSkill(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }
    
    public function updateSkill(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skills,name,' . $skill->id,
            'category' => 'nullable|string|max:255',
        ]);
        
        $skill->update($request->all());
        
        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill updated successfully.');
    }
    
    public function deleteSkill(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill deleted successfully.');
    }
    
    public function systemSettings()
    {
        return view('admin.settings');
    }
    
    public function updateSystemSettings(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'primary_color' => 'required|string|max:7',
            'enable_user_registration' => 'boolean',
            'enable_email_verification' => 'boolean',
        ]);
        
        // Update system settings in the database or env file
        // This is just a placeholder - actual implementation would depend on your settings storage strategy
        
        return back()->with('success', 'System settings updated successfully.');
    }
}