<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use App\Thread;

/**
 * Class FavoritesController
 *
 * @package App\Http\Controllers
 */
class FavoritesController extends Controller
{
    /**
     * FavoritesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param \App\Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Reply $reply)
    {
        $reply->like();

        return back();
    }

    /**
     * @param \App\Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reply $reply)
    {
        $favorite = $reply->favorites()->where('user_id', auth()->id())
                                        ->firstOrFail();

        $favorite->delete();

        return back();
    }

    /**
     * @param \App\Reply $reply
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function loginRedirect(Reply $reply)
    {

        $thread = Thread::where('id', $reply->thread_id)->firstOrFail();

        return redirect('threads/'.$thread->channel->slug.'/'.$thread->id);

    }
}
