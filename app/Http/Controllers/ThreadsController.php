<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilters;
use App\Http\Requests\ThreadStoreRequest;
use App\Services\SpamService;
use App\Thread;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    /**
     * @var SpamService
     */
    private $spam;

    public function __construct(SpamService $spam)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->spam = $spam;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel       $channel
     * @param ThreadFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ThreadStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadStoreRequest $request)
    {
        $thread = Thread::create([
            'title'      => $request->title,
            'body'       => $request->body,
            'channel_id' => $request->channel_id,
            'user_id'    => auth()->id(),
        ]);

        $this->spam->detect($request->body);
        $this->spam->detect($request->title);

        return redirect()
            ->to($thread->path())
            ->with('flash', __('Your thread has been published.'));
    }

    /**
     * Display the specified resource.
     *
     * @param string       $slug
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function show(string $slug, Thread $thread)
    {
        if(auth()->check()){
            cache()->forever(auth()->user()->visitedThreadCacheKey($thread), now());
        }

        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread $thread
     * @return void
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Thread              $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string       $channel
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(string $channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();
        if (request()->wantsJson()) {
            return response([], 204);
        }
        return redirect()->to(route('home'));
    }

    /**
     * @param Channel       $channel
     * @param ThreadFilters $filters
     * @return mixed
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);
        if ($channel->exists) {
            $threads = $threads->where('channel_id', $channel->id);
        }

        $threads = $threads->get();

        return $threads;
    }
}
