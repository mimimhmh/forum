<?php

namespace App\Http\Controllers;

use App\User;

class ProfilesController extends Controller
{
    /**
     * @param \App\User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {

        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => $this->getActivity($user),
        ]);
    }

    /**
     * @param \App\User $user
     * @return mixed
     */
    protected function getActivity(User $user)
    {
        $activities = $user->activity()->latest()
                            ->with('subject')->take(20)
                            ->get()->groupBy(function ($activity) {

                return $activity->created_at->format('Y-m-d');

                });

        return $activities;
    }
}
