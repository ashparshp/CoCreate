<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'creator_id',
        'start_date',
        'end_date',
        'status',
        'is_public',
        'requires_approval',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_public' => 'boolean',
        'requires_approval' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function joinRequests()
    {
        return $this->hasMany(JoinRequest::class);
    }
    
    /**
     * Get progress percentage for the project
     */
    public function getProgressPercentage()
    {
        $totalTasks = $this->tasks()->count();
        if ($totalTasks === 0) {
            return 0;
        }
        
        $completedTasks = $this->tasks()->where('status', 'completed')->count();
        return round(($completedTasks / $totalTasks) * 100);
    }
    
    /**
     * Get tasks grouped by status for kanban view
     */
    public function getTasksByStatus()
    {
        $tasksByStatus = [
            'to_do' => $this->tasks()->where('status', 'to_do')->get(),
            'in_progress' => $this->tasks()->where('status', 'in_progress')->get(),
            'review' => $this->tasks()->where('status', 'review')->get(),
            'completed' => $this->tasks()->where('status', 'completed')->get(),
        ];
        
        return $tasksByStatus;
    }
}