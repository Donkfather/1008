<?php

namespace App\Listeners;

use App\Event;
use App\Events\UserCreated;
use App\EventToken;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

class GenerateTokensForUser
{
    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $ev)
    {
        $tokens = collect();
        $user = $ev->user;

        Event::available()->get()->pluck('id')->each(function($event) use($user,$tokens){
           $tokens->push([
               'user_id' => $user->id,
               'event_id' => $event,
               'token' => Str::random(80)
           ]);
        });

        EventToken::insert($tokens->toArray());
    }
}
