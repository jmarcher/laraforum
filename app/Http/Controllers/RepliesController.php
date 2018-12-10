<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyStoreRequest;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    /**
     * Stores a reply likned to a thread
     *
     * @param  string            $channelSlug
     * @param  \App\Thread            $thread
     * @param  \App\Http\Requests\ReplyStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(string $channelSlug, Thread $thread, ReplyStoreRequest $request)
    {
        $thread->addReply([
            'body'    => $request->body,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->to($thread->path())
            ->with('flash', __('Your reply has been published.'));
    }
}
