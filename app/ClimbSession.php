<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ClimbSession
 *
 * @mixin \Eloquent
 */
class ClimbSession extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'date'
    ];

    protected $guarded = [];

    public function climbedRoutes()
    {
        return $this->hasMany(ClimbedRoute::class);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
