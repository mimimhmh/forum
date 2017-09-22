<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    /**
     * RepliesController constructor.
     */
    function __construct()
    {

        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Thread $thread
     * @param $channelId
     * @return \Illuminate\Http\Response
     */
    public function store($channelId, Thread $thread)
    {
        $data = request()->validate([
            'body' => 'required',
        ]);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => $data['body'],
        ]);

        return back()->with('flash', 'Replied successfully!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Reply $reply)
    {
        $reply->update(['body' => request('body')]  );

        if (request()->expectsJson()) {
            return response(['status' => 'Reply updated!']);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (\request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back()->with('flash', 'Reply deleted');
    }
}
