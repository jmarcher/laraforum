<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_notification_is_prepared_when_a_subscriber_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        $thread = create(Thread::class)->subscribe(auth()->id());

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'body'    => 'Some reply',
            'user_id' => auth()->id(),
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'body'    => 'Some reply',
            'user_id' => create(User::class)->id,
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_fetch_their_notifications()
    {
        create(DatabaseNotification::class);

        $user = auth()->user();

        $response = $this->getJson("/profiles/{$user->name}/notifications")->json();

        $this->assertCount(1, $response);
    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {
        create(DatabaseNotification::class);

        $user = auth()->user();

        $this->assertCount(1, $user->unreadNotifications);

        $notificationId = $user->unreadNotifications->first()->id;

        $this->delete("/profiles/{$user->name}/notifications/{$notificationId}");

    }
}
