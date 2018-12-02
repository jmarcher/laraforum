<?php

namespace App\Http\Middleware;

use App\Channel;
use Closure;

class ShareChannelsOnViewsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        view()->share('channels', Channel::all());
        return $next($request);
    }
}
