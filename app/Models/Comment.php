<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     * Only these fields can be set via Comment::create($data)
     */
    protected $fillable = [
        'task_id',
        'user_id',
        'comment',
    ];

    /**
     * Task this comment belongs to
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * User who made this comment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
