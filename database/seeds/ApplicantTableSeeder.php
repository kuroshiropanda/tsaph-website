<?php

use Illuminate\Database\Seeder;

class ApplicantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('applicants')->delete();

        factory(App\Applicant::class, 10)
           ->create()
           ->each(function (App\Applicant $applicant) {
                $applicant->application()->save(factory(App\Application::class, 8)->make());
            });
    }
}
