<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;

class NotifyThreadSubscribers
{

    /**
     * NotifyThreadSubscribers constructor.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  ThreadHasNewReply $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
        //prepare notifications for all subscribers.
        $event->thread->subscriptions
            ->where('user_id', '!=', $event->reply->user_id)
            ->each->notify($event->reply);
    }
}
