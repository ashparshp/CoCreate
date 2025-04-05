<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('category', 'asc')
            ->orderBy('name', 'asc')
            ->get();
        
        // Get user skills for highlighting current skills
        $userSkills = Auth::user()->skills()->pluck('skill_id')->toArray();
        
        return view('skills.index', compact('skills', 'userSkills'));
    }

    public function create()
    {
        return view('skills.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skills',
            'category' => 'nullable|string|max:255',
        ]);

        $skill = Skill::create($request->all());

        // If the user wants to add this skill to their profile immediately
        if ($request->has('add_to_profile') && $request->add_to_profile) {
            $proficiencyLevel = $request->input('proficiency_level', 1);
            Auth::user()->skills()->attach($skill->id, ['proficiency_level' => $proficiencyLevel]);
            return redirect()->route('profile.show')
                ->with('success', 'Skill created and added to your profile.');
        }

        return redirect()->route('skills.index')
            ->with('success', 'Skill created successfully.');
    }

    public function show(Skill $skill)
    {
        // Get users with this skill for networking purposes
        $users = $skill->users()->withPivot('proficiency_level')->get();
        return view('skills.show', compact('skill', 'users'));
    }

    public function edit(Skill $skill)
    {
        return view('skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skills,name,'.$skill->id,
            'category' => 'nullable|string|max:255',
        ]);

        $skill->update($request->all());

        return redirect()->route('skills.index')
            ->with('success', 'Skill updated successfully.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->route('skills.index')
            ->with('success', 'Skill deleted successfully.');
    }
    
    public function addToProfile(Request $request)
    {
        $request->validate([
            'skill_id' => 'required|exists:skills,id',
            'proficiency_level' => 'required|integer|min:1|max:5',
        ]);
        
        $user = Auth::user();
        // Check if already added
        if ($user->skills()->where('skill_id', $request->skill_id)->exists()) {
            // Update proficiency only
            $user->skills()->updateExistingPivot($request->skill_id, ['proficiency_level' => $request->proficiency_level]);
            return redirect()->back()->with('success', 'Skill proficiency updated successfully.');
        }
        
        // Add new skill to profile
        $user->skills()->attach($request->skill_id, ['proficiency_level' => $request->proficiency_level]);
        
        return redirect()->back()->with('success', 'Skill added to your profile successfully.');
    }
    
    public function removeFromProfile(Request $request, Skill $skill)
    {
        Auth::user()->skills()->detach($skill->id);
        return redirect()->back()->with('success', 'Skill removed from your profile.');
    }
}