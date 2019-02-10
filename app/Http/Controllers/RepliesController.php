<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyStoreRequest;
use App\Reply;
use App\Services\SpamService;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }


    /**
     * Stores a reply likned to a thread
     *
     * @param  string                               $channelSlug
     * @param  \App\Thread                          $thread
     * @param  \App\Http\Requests\ReplyStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(string $channelSlug, Thread $thread, ReplyStoreRequest $request, SpamService $spam)
    {
        $reply = $thread->addReply([
            'body'    => $request->body,
            'user_id' => auth()->id(),
        ]);

        $spam->detect($request->body);

        if ($request->expectsJson()) {
            return $reply->load('owner');
        }

        return redirect()
            ->to($thread->path())
            ->with('flash', __('Your reply has been published.'));
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['success' => true]);
        }

        return back();
    }

    public function update(Reply $reply, Request $request)
    {
        $this->authorize('update', $reply);

        $reply->update(['body' => $request->body]);
    }
}
