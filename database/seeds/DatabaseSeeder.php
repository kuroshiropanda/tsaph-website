<?php

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
        $this->call('RolesAndPermissionsSeeder');
        $this->call('UsersTableSeeder');
        $this->call('QuestionsTableSeeder');
        $this->call('TypeSeeder');
    }
}
