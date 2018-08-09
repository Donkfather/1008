<?php

namespace App\Listeners;

use App\EventToken;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

class GenerateUserTokensForEvent
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $tokens = collect();
        User::all()->pluck('id')->each(function($user) use($tokens,$event){
            $tokens->push([
                'user_id' => $user,
                'event_id' => $event->event->id,
                'token' => Str::random(80),
            ]);
        });

        EventToken::insert($tokens->toArray());
    }
}
