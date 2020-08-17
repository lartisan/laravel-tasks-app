<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'created_by',
        'assigned_to',
        'priority',
        'completed',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'datetime'
    ];

    public function getPriorityAttribute()
    {
        switch ($this->attributes['priority']) {
            case 3:
                return 'critical';
                break;
            case 2:
                return 'high';
                break;
            case 1:
                return 'medium';
                break;
            case 0:
                return 'low';
                break;
        }
    }

    /**
     * Get the user assigned for the task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the owner of a task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all the task assigned to the authenticated user
     *
     * @param Builder $query
     * @return mixed
     */
    public function scopeAssignedToMe(Builder $query)
    {
        return $query->orWhere('assigned_to', auth()->id());
    }

    /**
     * Get all the tasks created by the authenticated user
     *
     * @param Builder $query
     * @return mixed
     */
    public function scopeCreatedByMe(Builder $query)
    {
        return $query->orWhere('created_by', auth()->id());
    }

}
