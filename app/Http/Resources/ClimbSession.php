<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

/**
 * @mixin \App\ClimbSession
 */
class ClimbSession extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'date' => $this->date->toIso8601String(),
            'climbedRoutes' => new ClimbedRouteCollection($this->climbedRoutes()->get())
        ];
    }
}
