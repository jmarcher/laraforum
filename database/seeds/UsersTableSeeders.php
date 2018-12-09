<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        create(User::class, ['email' => 'admin@example.com']);
    }
}
