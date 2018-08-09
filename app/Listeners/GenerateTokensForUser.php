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
    }
}
