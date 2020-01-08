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
            ['question' => 'How/Where did you find out about TSAPH?', 'type' => 'text'],
            ['question' => 'Where are you currently located?', 'type' => 'text'],
            ['question' => 'What do you usually do on twitch?', 'type' => 'checkbox'],
            ['question' => 'How long have you been on twitch?', 'type' => 'text'],
            ['question' => 'How can you identify yourself while on twitch?', 'type' => 'textarea'],
            ['question' => 'What can you contribute to TSAPH to help us grow the community?', 'type' => 'textarea'],
            ['question' => 'What emote is better LUL or Kappa?', 'type' => 'text'],
            ['question' => 'Do you know what BTTV is? If yes, please indicate 3 examples. If no, just type no', 'type' => 'textarea'],
        ]);
    }
}
