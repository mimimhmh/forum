<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    /**
     * @param $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::whereName($username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }
}