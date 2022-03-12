<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'role_name',
    ];

    const ADMIN = 1;
    const MANAGER = 2;
    const USER = 3;
}
