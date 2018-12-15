<?php

namespace App\Support\Traits;

use App\Favorite;

trait CanBeFavorited
{

    protected static function bootCanBeFavorited()
    {
        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }

    public function isFavorited($userId)
    {
        return $this->favorites->where('user_id', $userId)->isNotEmpty();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited(auth()->id());
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

    public function unfavorite(int $userId)
    {
        $this->favorites()->where(['user_id' => $userId])->get()->each->delete();
    }
}
