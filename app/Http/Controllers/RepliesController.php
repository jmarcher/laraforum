<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(string $channelSlug, Thread $thread, Request $request)
    {
        $this->validate($request, [
            'body' => 'required',
        ]);

        $thread->addReply([
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        return redirect()->to($thread->path());
    }
}
