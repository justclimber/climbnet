<?php

namespace App\Models\Repositories;

use App\Lib\Cachable\Repository;

class User extends Repository
{
    public function __construct(\App\User $model)
    {
        parent::__construct($model);
    }
}