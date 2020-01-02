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

        factory(App\Applicant::class, 25)
           ->create()
           ->each(function (App\Applicant $applicant) {
                $applicant->answers()->save(factory(App\Answer::class)->make(['question_id' => 1]));
                $applicant->answers()->save(factory(App\Answer::class)->make(['question_id' => 2]));
                $applicant->answers()->save(factory(App\Answer::class)->make(['question_id' => 3]));
                $applicant->answers()->save(factory(App\Answer::class)->make(['question_id' => 4]));
                $applicant->answers()->save(factory(App\Answer::class)->make(['question_id' => 5]));
                $applicant->answers()->save(factory(App\Answer::class)->make(['question_id' => 6]));
                $applicant->answers()->save(factory(App\Answer::class)->make(['question_id' => 7]));
                $applicant->answers()->save(factory(App\Answer::class)->make(['question_id' => 8]));
            });
    }
}
