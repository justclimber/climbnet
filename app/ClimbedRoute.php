<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClimbedRoute extends Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function climbSession()
    {
        return $this->belongsTo(ClimbSession::class);
    }
}
