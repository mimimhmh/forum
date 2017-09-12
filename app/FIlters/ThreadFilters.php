<?php

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

class ThreadFilters
{

    protected $request;

    /**
     * ThreadFilters constructor.
     *
     * @param $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $builder
     * @return mixed
     */
    public function apply($builder)
    {
        //apply filters to the builder
        if (! $username = request('by'))
            return $builder;

        $user = User::whereName($username)->firstOrFail();

        return $builder->where('user_id', $user->id);

    }
}