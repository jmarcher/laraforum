<?php

namespace Tests\Unit;

use App\Services\SpamService;
use Tests\TestCase;

class SpamTest extends TestCase
{
    /** @test */
    public function it_checks_for_invalid_keywords()
    {
        $spam = new SpamService;

        $this->assertFalse($spam->detect('inocent reply body'));

        $this->expectException(\Exception::class);

        $spam->detect('yahoo customer service');
    }

    /** @test */
    public function it_checks_for_a_key_held_down()
    {
        $spam = new SpamService;

        $this->expectException(\Exception::class);

        $spam->detect('Hello world aaaaaaaaaaa');
    }
}
