<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'role_key','role_name',
    ];

    const SUPER_ADMIN = 1;
    const ADMIN = 2;
    const ANALYST = 3;
    const USER = 4;

    public function user(){
        return $this->belongsTo(User::class);
    }

    
}
