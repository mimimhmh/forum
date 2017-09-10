<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function unauthenticated_user_may_not_add_replies()
    {
        $this->expectException(AuthenticationException::class);

        $thread = create(Thread::class);

        $reply = make(Reply::class);

        $this->post($thread->path().'/replies', $reply->toArray());
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_participate_in_forum_threads()
    {

        $this->signIn();

        $thread = create(Thread::class);

        $reply = make(Reply::class);

        $this->post($thread->path().'/replies', $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }
}