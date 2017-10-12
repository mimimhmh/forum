<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToThreadsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_subscribe_to_threads()
    {
        $this->signIn();

        // Given we have a thread
        $thread = create(Thread::class);

        // And the user subscribes to the thread..
        $this->post($thread->path().'/subscriptions');

        // Then, each time a new reply is left...
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here',
        ]);

        // A notification should be prepared for the user

    }

    /**
     * @test
     */
    public function a_user_can_unsubscribe_from_threads()
    {
        $this->signIn();

        // Given we have a thread
        $thread = create(Thread::class);

        $thread->subscribe();

        $this->delete($thread->path().'/subscriptions');

        $this->assertCount(0, $thread->subscriptions);

    }
}
