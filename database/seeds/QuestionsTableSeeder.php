<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->delete();

        DB::table('questions')->insert([
            ['question' => 'What do you usually do on twitch?', 'type' => 'checkbox'],
            ['question' => 'How/Where did you find out about TSAPH?', 'type' => 'text'],
            ['question' => 'Where are you currently located?', 'type' => 'text'],
            ['question' => 'How long have you been on twitch?', 'type' => 'text'],
            ['question' => 'How can you identify yourself while on twitch?', 'type' => 'textarea'],
            ['question' => 'What can you contribute to TSAPH to help us grow the community?', 'type' => 'textarea'],
        ]);
    }
}
