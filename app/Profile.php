<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'companyName', 'domain', 'ipAddress', 'keywords'
    ];

    protected $casts = [
        'keywords' => 'array'
    ];
}
