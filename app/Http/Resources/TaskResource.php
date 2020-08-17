<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'owner' => $this->owner->name,
            'assignee' => $this->assignee->name,
            'priority' => $this->priority,
            'completed' => (boolean) $this->completed,
            'dueDate' => $this->due_date->diffForHumans()
        ];
    }
}
