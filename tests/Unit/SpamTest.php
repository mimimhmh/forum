<?php

namespace Tests\Unit;

use App\Utilities\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{
    /**
     * @test
     */
    public function it_validate_spam()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('slag'));

    }
}
