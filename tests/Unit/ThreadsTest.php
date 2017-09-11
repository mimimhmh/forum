<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    protected function setUp()
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }

    /**
     * @test
     */
    public function a_thread_can_make_a_string_path()
    {
        $thread = create(Thread::class);

        $this->assertEquals("/threads/{$thread->channel->slug}/$thread->id", $thread->path());
    }

    /**
     * @test
     */
    public function a_thread_has_replies()
    {

        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /**
     * @test
     */
    public function a_thread_has_a_creator()
    {

        $response = $this->get($this->thread->path());

        $response->assertSee($this->thread->creator->name);
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /**
     * @test
     */
    public function a_thread_can_add_a_reply()
    {

        $this->thread->addReply([
            'user_id' => 1,
            'body' => 'Foobar',
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /**
     * @test
     */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf(Channel::class, $thread->channel);
    }
}
