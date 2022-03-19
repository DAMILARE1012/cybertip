<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ThreatIntel extends Model
{
    //
    use HasFactory;

    protected $table = "threat_intels";
    protected $fillable = [
        'alias', 'real_name', 'post', 'url', 'time', 'geolocation', 'source'
    ];
}
 