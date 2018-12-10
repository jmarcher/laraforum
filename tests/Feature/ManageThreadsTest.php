<?php
/**
 * Created by PhpStorm.
 * User: gordo
 * Date: 05.12.18
 * Time: 23:29
 */

namespace Tests\Feature;


use App\Activity;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ManageThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn(create(User::class, ['email' => 'admin@example.org']));

        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $this->json('DELETE', $thread->path())
            ->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertDatabaseMissing('activities', [
            'subject_id'   => $thread->id,
            'subject_type' => get_class($thread),
        ]);
        $this->assertDatabaseMissing('activities', [
            'subject_id'   => $reply->id,
            'subject_type' => get_class($reply),
        ]);

        $this->assertCount(0, Activity::all());
    }

    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create(Thread::class);

        $this->delete($thread->path())
            ->assertRedirect('/login');

        $this->assertDatabaseHas('threads', ['id' => $thread->id]);

        $this->signIn();

        $this->delete($thread->path())
            ->assertStatus(403);

    }
}
