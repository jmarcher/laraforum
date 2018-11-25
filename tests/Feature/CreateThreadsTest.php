<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authenticated_user_should_be_able_to_create_threads()
    {

        $this->signIn();

        $thread = make(Thread::class);

        $this->post('/threads', $thread->toArray());

        $response = $this->get($thread->path());

        $response->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->expectException(AuthenticationException::class);
        $thread = make(Thread::class);

        $this->post('/threads', $thread->toArray());
    }
}
