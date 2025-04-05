<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'bio',
        'profile_photo_path',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];
    
    protected $attributes = [
        'role' => 'user',
        'is_active' => true,
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class)
            ->withPivot('proficiency_level')
            ->withTimestamps();
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    public function createdProjects()
    {
        return $this->hasMany(Project::class, 'creator_id');
    }

    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    public function uploadedFiles()
    {
        return $this->hasMany(File::class, 'uploaded_by');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function joinRequests()
    {
        return $this->hasMany(JoinRequest::class);
    }
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}