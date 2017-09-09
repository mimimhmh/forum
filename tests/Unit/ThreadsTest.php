<?php

namespace Tests\Unit;

use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadsTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_thread_has_replies(){

        $thread = factory(Thread::class)->create();

        $this->assertInstanceOf(Collection::class, $thread->replies);
    }

    /**
     * @test
     */
    public function a_thread_has_a_creator()
    {
        $thread = factory(Thread::class)->create();

        $response = $this->get('/threads/'.$thread->id);

        $response->assertSee($thread->creator->name);
        $this->assertInstanceOf(User::class, $thread->creator);
    }
}
