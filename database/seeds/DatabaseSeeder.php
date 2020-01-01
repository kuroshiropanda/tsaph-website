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
        // $this->call(UsersTableSeeder::class);
        $this->call('RolesAndPermissionsSeeder');
        $this->call('UsersTableSeeder');
        $this->call('QuestionsTableSeeder');
        $this->call('ApplicantTableSeeder');

        $this->command->info('Questions table seeded');
        $this->command->info('Applicant table seeded');
    }
}
