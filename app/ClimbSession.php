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
}
