<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityRecord extends Model
{
    protected $fillable = [
        'user_id', 'activity_status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
