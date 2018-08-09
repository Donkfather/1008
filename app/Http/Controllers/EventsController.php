<?php

namespace App\Http\Controllers;

use App\CheckinLocation;
use App\Event;
use App\EventToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Cache::remember('events',15,function(){
            return Event::all();
        });
        return response()->json(['events' => Event::all()]);
    }

    public function checkin(Event $event)
    {
        request()->validate([
            'location' => 'required',
            'location.lat' => 'required|numeric',
            'location.lng' => 'required|numeric',
        ]);

        abort_unless($event->status === 'active', 422);

        $userToken = EventToken::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->first();

        abort_if($userToken,403);

        try {
            \DB::beginTransaction();
            EventToken::create([
                'event_id' => $event->id,
                'user_id' => auth()->id(),
                'checkin_at' => now(),
            ]);
            CheckinLocation::create([
                'event_id' => $event->id,
                'lat' => request('location')['lat'],
                'lng' => request('location')['lng'],
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();

        return response()->json(['event' => $event->fresh()]);
    }
}
