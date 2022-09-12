<?php

namespace App\Listeners;

use App\Events\UserCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ActivationCodeListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreatedEvent $event)
    {
        // Send an email here
        Log::info('activation code listener received!!!', $event->user->toArray());
        // generate the activation link and send it via email here
        // activation link should contain a token, which is stored in the database
        // each token is valid for one-time usage and for a tiny period of time
        // user shouldn't be able to get emails frequents per same time (spam)
    }
}
