<?php

namespace Tests\Feature;

use App\Favorite;
use App\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavouritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_can_not_favorite_anything()
    {
        $this->withExceptionHandling()
            ->post('/replies/1/favorites')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_favourite_any_reply()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $reply = create(Reply::class);

        $this->post('/replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_unfavourite_a_reply()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $reply = create(Reply::class);

        create(Favorite::class, [
            'user_id'        => auth()->id(),
            'favorited_type' => get_class($reply),
            'favorited_id'   => $reply->id,
        ]);

        $this->assertCount(1, $reply->favorites);

        $this->delete('/replies/' . $reply->id . '/favorites');

        $this->assertCount(0, $reply->fresh()->favorites);
    }


    /** @test */
    public function an_authenticated_user_may_favourite_a_reply_only_once()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->post('/replies/' . $reply->id . '/favorites');
        $this->post('/replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }
}
