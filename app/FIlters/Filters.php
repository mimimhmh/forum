<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $request;

    protected $builder;

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
        $this->builder = $builder;

        //apply filters to the builder
        //if (! $username = request('by'))
        //    return $builder;

        if ($this->request->has('by')) {
            $this->by($this->request->by);
        }

        return $this->builder;
    }
}