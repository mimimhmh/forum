<?php

namespace App\Traits;

use App\Activity;

trait RecordsActivity
{
    /**
     *
     */
    protected static function bootRecordsActivity()
    {
        static:: created(function ($thread) {
            $thread->recordActivity('created');
        });
    }

    /**
     * @param $event
     */
    protected function recordActivity($event)
    {
        Activity::create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
            'subject_id' => $this->id,
            'subject_type' => get_class($this),
        ]);
    }

    /**
     * @param $event
     * @return string
     */
    protected function getActivityType($event)
    {
        return $event.'_'.strtolower((new \ReflectionClass($this))->getShortName());
    }
}