<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular'];

    /**
     * Filter the query by username
     *
     * @param $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::whereName($username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * @return mixed
     */
    protected function popular()
    {
        return $this->builder->orderBy('replies_count', 'desc');
    }
}