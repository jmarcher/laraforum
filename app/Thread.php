<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use App\Support\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected $appends = ['is_subscribed_to'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

        static::deleting(function (Thread $thread) {
            $thread->replies->each->delete();
        });

    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        // Send notifications to all subscribers.
        $this->notifySubscribers($reply);

        return $reply;
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe(int $userId): Thread
    {
        $this->subscriptions()->create([
            'user_id' => $userId,
        ]);

        return $this;
    }

    public function unsubscribe(int $userId)
    {
        $this->subscriptions()
            ->where('user_id', $userId)
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function isSubscribedToUser(int $userId)
    {
        return $this->subscriptions()
            ->where('user_id', $userId)
            ->exists();
    }

    public function getIsSubscribedToAttribute()
    {
        return auth()->check() && $this->isSubscribedToUser(auth()->id());
    }

    /**
     * @param $reply
     */
    protected function notifySubscribers(Reply $reply): void
    {
        $this->subscriptions
            ->where('user_id', '!=', $reply->user_id)
            ->each(function ($subscription) use ($reply) {
                $subscription->user->notify(new ThreadWasUpdated($this, $reply));
            });
    }
}
