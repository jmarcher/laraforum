<?php
/**
 * Created by PhpStorm.
 * User: gordo
 * Date: 02.12.18
 * Time: 17:48
 */

namespace App\Filters;


use App\User;
use Illuminate\Database\Query\Builder;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular'];


    /**
     * Filter the query by a given username.
     * @param  string $username
     * @return Builder
     */
    public function by($username)
    {
        $user = User::whereName($username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query accoring to most popular threads.
     * @return Builder
     */
    public function popular()
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }
}
