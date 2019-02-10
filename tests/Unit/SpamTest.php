<?php

namespace Tests\Unit;

use App\Reply;
use App\Services\SpamService;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpamTest extends TestCase
{
    /** @test */
    public function it_validates_spam()
    {
        $spam = new SpamService();

        $this->assertFalse($spam->detect('inocent reply body'));
    }
}
