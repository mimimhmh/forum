<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')->assertRedirect('/login');

        $this->get('/threads/create')->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_create_new_forum_threads()
    {

        $this->signIn();

        $thread = make(Thread::class);

        $response = $this->post('/threads', $thread->toArray());

        $path = $response->headers->get('location');

        $this->get($path)->assertSee($thread->title)->assertSee($thread->body);
    }
}
