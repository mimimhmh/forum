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

    /**
     * @test
     */
    public function a_thread_can_be_subscribed_to()
    {
        //given we have a thread
        $thread = create(Thread::class);

        //And an authenticated user

        //When a user subscribe a thread
        $thread->subscribe($userId = 1);

        //Then we should be able to fetch all threads that the user has subscribed to.
        $this->assertEquals(1, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    /**
     * @test
     */
    public function a_thread_can_be_unsubscribed_from()
    {
        //given we have a thread
        $thread = create(Thread::class);

        //When a user subscribe a thread
        $thread->subscribe($userId = 1);

        //a user unsubscribe a thread
        $thread->unsubscribe($userId);

        $this->assertCount(0, $thread->subscriptions);
    }

    /**
     * @test
     */
    public function it_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        $thread = create(Thread::class);

        $this->signIn();

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }
}
