<?php
/**
 * Created by PhpStorm.
 * User: gordo
 * Date: 02.12.18
 * Time: 17:48
 */

namespace App\Filters;


use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by'];

    public function by($username)
    {
        $user = User::whereName($username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }
}
