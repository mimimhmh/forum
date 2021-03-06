<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * @param \App\User $user
     * @return mixed
     */
    public static function feed(User $user, $take = 20)
    {
        return static::where('user_id', $user->id)
                    ->latest()
                    ->with('subject')
                    ->take($take)
                    ->get()->groupBy(function ($activity) {

                return $activity->created_at->format('Y-m-d');

            });
    }
}
