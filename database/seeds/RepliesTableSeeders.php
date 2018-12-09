<?php

use App\Thread;
use App\User;
use Illuminate\Database\Seeder;

class RepliesTableSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Thread::all()->each(function (Thread $thread) {
            if (rand(1, 100) > 70) {
                create(\App\Reply::class, ['thread_id' => $thread->id, 'user_id' => User::whereEmail('admin@example.com')->first()->id], 5);
            } else {
                create(\App\Reply::class, ['thread_id' => $thread->id], 5);
            }
        });
    }
}
