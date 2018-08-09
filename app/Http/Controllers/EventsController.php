<?php

namespace App\Http\Controllers;

use App\CheckinLocation;
use App\Event;
use App\EventToken;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['events' => Event::all()]);
    }

    public function checkin(Event $event)
    {
        request()->validate([
            'token' => 'required',
            'location' => 'required|array',
            'location.*' => 'numeric'
        ]);

        abort_unless($event->status === 'active', 422);

        $userToken = EventToken::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->whereNotNull('token')
            ->whereNull('used_at')
            ->firstOrFail();

        try {
            \DB::beginTransaction();
            $userToken->token = null;
            $userToken->used_at = Carbon::now();
            $userToken->save();
            CheckinLocation::create([
                'event_id' => $event->id,
                'lat' => request('location')[0],
                'lng' => request('location')[1],
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();

        return response()->json(['event' => $event->fresh()]);
    }
}
