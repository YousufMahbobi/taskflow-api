<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * Protects against malicious mass assignment from requests.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'job_title',
        'avatar',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     *  Tasks assigned to this user (primary owner/assignee)
     */
    public function assignedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assignee_id');
    }

    /**
     * Tasks created by this user (manager/admin)
     */
    public function createdTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    /**
     * Tasks where user is collaborator
     */
    public function collaboratedTasks(): belongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_user')
            ->withPivot('role_in_task', 'assigned_at', 'accepted_at')
            ->withTimestamps();
    }

    /*
     * Comments made by the user
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
