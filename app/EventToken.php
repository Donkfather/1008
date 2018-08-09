<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventToken extends Model
{
    public $timestamps = false;
    protected $dates = ['checkin_at'];
    protected $fillable = ['user_id', 'event_id', 'checkin_at'];

}
