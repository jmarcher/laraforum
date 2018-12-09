<?php

use App\User;
use Illuminate\Database\Seeder;

class ThreadsTableSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        create(\App\Thread::class, [], 50);
        create(\App\Thread::class, ['user_id' => User::whereEmail('admin@example.com')->first()->id], 5);
    }
}
