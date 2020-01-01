<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;

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

        $user = User::create([
            'username' => 'kuro',
            'name' => 'AJ',
            'email' => 'kuroshiropanda@outlook.com',
            'password' => '$2y$10$Oj1R.gbBVQ8/DU3/BLuP5.WSASlf7sC3zSI/PhAGGFz1oN.zjz9g2'
        ]);

        $user->assignRole('super admin');

        // DB::table('users')->insert([
        //     ['username' => 'kuro', 'name' => 'AJ', 'email' => 'kuroshiropanda@outlook.com', 'password' => '$2y$10$Oj1R.gbBVQ8/DU3/BLuP5.WSASlf7sC3zSI/PhAGGFz1oN.zjz9g2'],
        // ]);
    }
}
