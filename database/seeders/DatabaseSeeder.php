<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory()->create();
//        $user = [
//            'name' => 'Admin',
//            'email' => 'admin@email.com',
//            'password' => bcrypt('password')
//        ];
//        User::create($user);
    }
}
