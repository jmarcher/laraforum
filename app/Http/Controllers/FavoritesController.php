<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function store(Reply $reply)
    {
        return $reply->favorite(auth()->id());
    }
}
