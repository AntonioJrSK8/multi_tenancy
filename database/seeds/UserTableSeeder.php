<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class,1)->create([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'account_id' => 1
        ]);

        factory(App\User::class, 1)->create([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'account_id' => 2
        ]);
    }
}
