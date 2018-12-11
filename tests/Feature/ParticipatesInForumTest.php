<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipatesInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_unauthenticated_user_may_not_participate_in_a_forum_thread()
    {
        $this->expectException(AuthenticationException::class);

        $this->post('threads/fake-slug/1/replies', []);
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_a_forum_thread()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $reply = make(Reply::class);

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_needs_a_body()
    {
        $this->withExceptionHandling()->signIn();
        $thread = create(Thread::class);

        $reply = make(Reply::class, ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function unauthorized_users_may_not_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = create(Reply::class);

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_may_delete_replies()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
}
