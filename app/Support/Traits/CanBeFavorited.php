<?php

namespace App\Support\Traits;

use App\Favorite;
use App\Reply;

trait CanBeFavorited
{

    public function isFavorited($userId)
    {
        return $this->favorites->where('user_id', $userId)->isNotEmpty();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite($userId)
    {
        if (!$this->isFavorited($userId)) {
            $this->favorites()->create(['user_id' => $userId]);
        }
    }
}
