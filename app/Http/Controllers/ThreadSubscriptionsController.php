<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadSubscriptionsController extends Controller
{
    public function store(string $channel, Thread $thread)
    {
        $thread->subscribe(auth()->id());
    }

    public function destroy(string $channel, Thread $thread)
    {
        $thread->unsubscribe(auth()->id());
    }
}
