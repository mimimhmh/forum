<?php

namespace App\Traits;

trait Favorable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(\App\Favorite::class, 'favorited');
    }

    /**
     *
     */
    public function like()
    {
        $attr = ['user_id' => auth()->id()];
        //prevent favorite twice
        if (! $this->favorites()->where($attr)->exists()) {
            $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    /**
     * @return bool
     */
    public function isFavorited()
    {
        return ! ! $this->favorites->where('user_id', auth()->id())->count();
    }

    /**
     * @return int
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}