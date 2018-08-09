<?php

namespace App;

use App\Events\NewCheckinLocation;
use Illuminate\Database\Eloquent\Model;

class CheckinLocation extends Model
{
    protected $fillable = ['event_id','lat','lng'];

    protected $dispatchesEvents = [
        'created' => NewCheckinLocation::class
    ];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float'
    ];
}
