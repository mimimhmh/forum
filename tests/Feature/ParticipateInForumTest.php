<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
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
        $this->withExceptionHandling();

        $this->post('/threads/some-channel/1/replies', [])->assertRedirect('/login');
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

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);

        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    /**
     * @test
     */
    public function a_reply_requires_body()
    {

        $this->withExceptionHandling()->signIn();

        $thread = create(Thread::class);

        $reply = make(Reply::class, ['body' => null]);

        $this->post($thread->path().'/replies', $reply->toArray())->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_delete_reply()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, $reply->thread->refresh()->replies_count);
    }

    /**
     * @test
     */
    public function unauthenticated_user_can_not_update_reply()
    {

        $this->withExceptionHandling();

        $reply = create(Reply::class);

        $updatedWords = "you haven been changed";

        $this->patch("/replies/{$reply->id}", ['body' => $updatedWords])->assertRedirect("/login");
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_update_reply()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $updatedWords = "you haven been changed";

        $response = $this->patch("/replies/{$reply->id}", ['body' => $updatedWords]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedWords]);
    }
}
