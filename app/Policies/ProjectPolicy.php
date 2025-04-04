<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function view(User $user, Project $project)
    {
        // User can view if they are a member or if the project is public
        return $project->is_public || $project->members->contains($user);
    }

    public function update(User $user, Project $project)
    {
        // Only members can update
        $membership = $project->members()
            ->where('user_id', $user->id)
            ->wherePivotIn('role', ['owner', 'member'])
            ->first();
            
        return $membership !== null;
    }

    public function delete(User $user, Project $project)
    {
        // Only the creator can delete the project
        return $user->id === $project->creator_id;
    }
}
