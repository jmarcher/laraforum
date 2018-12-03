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
        $user = ['user_id' => $userId];
        if (!$this->favorites()->where($user)->exists()) {
            $this->favorites()->create($user);
        }
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
}
