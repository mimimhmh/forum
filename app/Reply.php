<?php

namespace App;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Favorable;

/**
 * App\Reply
 *
 * @property-read \App\User $owner
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property int $thread_id
 * @property string $body
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereThreadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereUserId($value)
 */
class Reply extends Model
{
    use Favorable, RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected $appends = ['favoritesCount', 'isFavorited'];

    protected static function boot()
    {
        parent::boot();

        static ::deleting(function ($reply){
            $reply->favorites->each->delete();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {

        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return mixed
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * @return string
     */
    public function path()
    {

        return $this->thread->path().'#reply-'.$this->id;
    }
}
