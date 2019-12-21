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
        $this->call('QuestionsTableSeeder');

        $this->command->info('Questions table seeded');
    }
}

class QuestionsTableSeeder extends Seeder {
    public function run() {
        DB::table('questions')->delete();

        DB::table('questions')->insert([
            ['question' => 'What is your twitch name?'],
            ['question' => 'How did you find out about TSAPH?'],
            ['question' => 'Where are you currently located?'],
            ['question' => 'What do you usually do on twitch?'],
            ['question' => 'How long have you been on twitch?'],
            ['question' => 'How can you identify yourself while on twitch?'],
            ['question' => 'What can you contribute to TSAPH to help us grow the community?'],
            ['question' => 'What emote is better LUL or Kappa?'],
            ['question' => 'Do you know what BTTV is? If yes, please indicate 3 examples. If no, just type no']
        ]);
    }
}
