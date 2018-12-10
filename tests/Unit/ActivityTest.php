<?php

namespace Tests\Unit;

use App\Activity;
use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->assertDatabaseHas('activities', [
            'type'         => 'created_thread',
            'user_id'      => auth()->id(),
            'subject_id'   => $thread->id,
            'subject_type' => Thread::class,
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->assertCount(2, Activity::all());

        $activity = Activity::all()->last();

        $this->assertEquals($activity->subject->id, $reply->id);
    }

    /** @test */
    public function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();
        create(Thread::class, ['user_id' => auth()->id()], 2);

        auth()->user()->activity()->first()->update(['created_at' => now()->subWeek()]);

        $feed = Activity::feed(auth()->user());

        $this->assertTrue($feed->keys()->contains(now()->format('Y-m-d')));

        $this->assertTrue($feed->keys()->contains(now()->subWeek()->format('Y-m-d')));
    }
}
