<?php

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->delete();

        DB::table('types')->insert([
            ['type' => 'Viewer'],
            ['type' => 'Moderator'],
            ['type' => 'Streamer'],
            ['type' => 'Other']
        ]);
    }
}
