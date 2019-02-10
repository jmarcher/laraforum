<?php

namespace Tests\Unit;

use App\Channel;
use App\Notifications\ThreadWasUpdated;
use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var Thread
     */
    protected $thread;

    protected function setUp()
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }

    /** @test */
    public function a_thread_contains_a_collection_of_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    public function a_thread_can_make_a_string_path()
    {
        $thread = create(Thread::class);

        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }

    /** @test */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body'    => 'Foobar',
            'user_id' => create(User::class)->id,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_notifies_all_subscribed_users_when_a_reply_is_added()
    {
        Notification::fake();
        $this->signIn();

        $this->thread->subscribe(auth()->id());

        $this->thread->addReply([
            'body'    => 'Foobar',
            'user_id' => create(User::class)->id,
        ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf(Channel::class, $thread->channel);
    }

    /** @test */
    public function a_thread_can_be_susbcribed_to()
    {
        $thread = create(Thread::class);

        $this->signIn();

        $thread->subscribe(auth()->id());

        $subscriptions = $thread->subscriptions()->where('user_id', auth()->id())->get();

        $this->assertInstanceOf(Collection::class, $subscriptions);
        $this->assertCount(1, $subscriptions);
    }

    /** @test */
    public function a_thread_can_be_unsusbcribed_to()
    {
        $thread = create(Thread::class);

        $this->signIn();

        $thread->unsubscribe(auth()->id());

        $subscriptions = $thread->subscriptions()->where('user_id', auth()->id())->get();

        $this->assertEmpty($subscriptions);
    }

    /** @test */
    public function it_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->assertFalse($thread->isSubscribedToUser(auth()->id()));

        $thread->subscribe(auth()->id());

        $this->assertTrue($thread->isSubscribedToUser(auth()->id()));
    }

    /** @test */
    public function a_thread_can_check_if_the_authenticated_user_has_read_all_the_new_replies()
    {
        $this->signIn();

        tap(auth()->user(), function (User $user) {
            $thread = create(Thread::class);

            $this->assertTrue($thread->hasUpdatesFor($user));

            cache()->forever($user->visitedThreadCacheKey($thread), now());

            $this->assertFalse($thread->hasUpdatesFor($user));
        });

    }
}
