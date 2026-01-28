<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     * Only these fields can be set via Task::create($data)
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'estimate',
        'due_date',
        'assignee_id',
        'created_by',
    ];

    /**
     * The primary user responsible for the task.
     */
    public function assignee(): belongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /**
     * User who created this task (manager/admin).
     */
    public function creator(): belongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Collaborators on this task
     */
    public function collaborators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user')
            ->withPivot('role_in_task', 'assigned_at', 'accepted_at')
            ->withTimestamps();
    }

    /**
     * Comments on this task
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

}
