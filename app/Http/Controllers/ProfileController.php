<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(): View
    {
        $user = Auth::user();
        $skills = $user->skills()->withPivot('proficiency_level')->get();
        
        return view('profile.show', compact('user', 'skills'));
    }

    /**
     * Display the user's profile edit form.
     */
    public function edit(): View
    {
        $user = Auth::user();
        $userSkills = $user->skills()->pluck('skill_id')->toArray();
        $allSkills = Skill::orderBy('category')->orderBy('name')->get();
        
        return view('profile.edit', compact('user', 'userSkills', 'allSkills'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
            'proficiency_level' => 'nullable|array',
            'proficiency_level.*' => 'integer|min:1|max:5',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        // Update skills
        $skills = [];
        if ($request->has('skills')) {
            foreach ($request->skills as $skillId) {
                $proficiency = $request->proficiency_level[$skillId] ?? 1;
                $skills[$skillId] = ['proficiency_level' => $proficiency];
            }
        }
        
        $user->skills()->sync($skills);

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}