<?php

namespace Tests\Feature;

use App\Thread;
use App\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{

    use DatabaseMigrations;

    private $thread;

    public function setUp() {

        parent::setUp();

        $this->thread = factory(Thread::class)->create();
    }

    /**
     * @test
     */
    public function a_user_can_view_all_threads() {

        $response = $this->get('/threads');

        $response->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function a_user_can_view_a_single_thread() {

        $response = $this->get('/threads/' . $this->thread->id);

        $response->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function a_user_can_view_replies_associated_with_the_thread() {

        $reply = factory(Reply::class)->create([
            'thread_id' => $this->thread->id
        ]);

        $response = $this->get('/threads/' . $this->thread->id);

        $response->assertSee($reply->body);

    }
}
