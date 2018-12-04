<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorite($userId)
    {
        if (! $this->isFavorited($userId)) {
            $this->favorites()->create(['user_id' => $userId]);
        }
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function isFavorited($userId)
    {
        return $this->favorites()->where('user_id', $userId)->exists();
    }
}
