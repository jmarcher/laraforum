<?php

namespace App;

use App\Support\Traits\CanBeFavorited;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use CanBeFavorited;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
