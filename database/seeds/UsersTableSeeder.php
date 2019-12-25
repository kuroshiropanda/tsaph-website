<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            ['username' => 'kuro', 'name' => 'AJ', 'email' => 'kuroshiropanda@outlook.com', 'password' => '$2y$10$Oj1R.gbBVQ8/DU3/BLuP5.WSASlf7sC3zSI/PhAGGFz1oN.zjz9g2'],
        ]);
    }
}
