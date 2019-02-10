<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email',
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function threads()
    {
        return $this->hasMany(Thread::class)
            ->orderBy('created_at', 'desc');
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function visitedThreadCacheKey(Thread $thread): string
    {
        return sprintf('users.%s.visits.%s', $this->id, $thread->id);
    }
}
