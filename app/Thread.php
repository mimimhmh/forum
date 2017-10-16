<?php

namespace App;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Thread
 *
 * @package App
 */
class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator'];

    protected $append = ['isSubscribedTo'];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->activity()->delete();
            $thread->replies->each->delete();
        });
    }

    /**
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/$this->id";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {

        return $this->hasMany(Reply::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {

        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return mixed
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @param  \App\Reply $reply
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addReply($reply)
    {
        ////prepare notifications for all subscribers.
        //foreach ($this->subscriptions as $subscription) {
        //    if ($subscription->user_id != $reply->user_id) {
        //        $subscription->user->notify(new ThreadWasUpdated($this, $reply));
        //    }
        //}

        $reply = $this->replies()->create($reply);

        $this->notifySubscribers($reply);

        //Way 2
        //event(new ThreadHasNewReply($this, $reply));

        return $reply;
    }

    /**
     * @param $query
     * @param $filters
     * @return mixed
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    /**
     * @param null $userId
     * @return $this
     */
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id(),
        ]);

        return $this;
    }

    /**
     * @param null $userId
     */
    public function unsubscribe($userId = null)
    {
        $this->subscriptions()->where('user_id', $userId ?: auth()->id())->delete();
    }

    /**
     * @return mixed
     */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    /**
     * Determine if the current user is subscribed to the thread.
     *
     * @return boolean
     */
    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()->where('user_id', auth()->id())->exists();
    }

    /**
     * Determine if the thread has been updated since the user last read it.
     *
     * @param User $user
     * @return bool
     */
    public function hasUpdatesFor($user)
    {
        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    /**
     * @param $reply
     */
    protected function notifySubscribers($reply): void
    {
        $this->subscriptions->where('user_id', '!=', $reply->user_id)->each->notify($reply);
    }
}
