<?php

namespace App\Events;

use App\CheckinLocation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewCheckinLocation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $event_id;
    public $lat;
    public $lng;

    /**
     * Create a new event instance.
     *
     * @param CheckinLocation $checkinLocation
     */
    public function __construct(CheckinLocation $checkinLocation)
    {
        $this->lat = $checkinLocation->lat;
        $this->lng = $checkinLocation->lng;
        $this->event_id = $checkinLocation->event_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('event-'.$this->event_id);
    }
}
