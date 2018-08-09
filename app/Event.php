<?php

namespace App;

use App\Events\EventCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Event extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'end_date'
    ];
    protected $dates = [
        'start_date',
        'end_date',
    ];

    protected $dispatchesEvents = [
        'created' => EventCreated::class,
    ];

    protected $casts = [
        'id' => 'integer'
    ];

    protected $with = ['userToken'];

    protected $appends = ['status'];

    public function userToken()
    {
        return $this->hasOne(EventToken::class)->where('user_id', auth()->id() ?? 0);
    }

    public function scopeAvailable($query)
    {
        return $query->where('end_date', '>', Carbon::now()->addMinutes(10));
    }

    public function checkins()
    {
        return $this->hasMany(CheckinLocation::class);
    }

    public function getStatusAttribute()
    {
        if ($this->end_date->isFuture() && $this->start_date->isPast()) {
            return 'active';
        } else if ($this->start_date->isFuture()) {
            return 'future';
        }

        return 'past';
    }
}
