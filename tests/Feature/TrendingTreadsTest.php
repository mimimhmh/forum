<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrendingTreadsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        Redis::del('trending_threads');
    }

    /**
     * @test
     */
    public function it_increments_a_threads_score_each_time_it_is_read()
    {
        $this->assertCount(0, Redis::zrevrange('trending_threads', 0, -1));

        $thread = create(Thread::class);

        $this->call('GET', $thread->path());

        $threading = Redis::zrevrange('trending_threads', 0, -1);

        $this->assertCount(1, $threading);

        //dd($threading);

        $this->assertEquals($thread->title, json_decode($threading[0])->title);
    }
}
