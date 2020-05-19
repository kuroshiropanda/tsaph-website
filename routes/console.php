<?php

use Illuminate\Foundation\Inspiring;
use App\Applicant;
use App\Member;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('applicant:update', function () {
    $api = resolve('App\Services\TwitchApi');

    $applicants = Applicant::all();

    foreach($applicants as $a)
    {
        $data = $api->get('users', [
            'query' => [
                'id' => $a->twitch_id
            ]
        ]);

        $a->username = $data->data[0]->login;
        $a->avatar = $data->data[0]->profile_image_url;
        $a->save();
    }
})->describe('Updates applicants data; i.e. avatars, username');

Artisan::command('member:update', function () {
    $api = resolve('App\Services\TwitchApi');

    $data = $api->getKraken('teams/tsaph');

    foreach($data->users as $d) {
        $app = \App\Applicant::where('twitch_id', $d->_id)
                            ->where('invited', false)
                            ->first();
        if($app) {
            $app->invited = true;
            $app->save();
        }

        Member::updateOrCreate(
            ['twitch_id' => $d->_id],
            ['username' => $d->display_name, 'avatar' => $d->logo]
        );
    }
})->describe('Update list of members and their data');

Artisan::command('applicants:deadline', function () {
    $discord = resolve('App\Services\DiscordApi');
    $applicant = resolve('App\Services\ApplicantService');

    $applicants = Applicant::where('approved', false)->where('invited', false)->get();

    foreach($applicants as $a) {
        $date = $a->created_at->diffInWeeks($a->created_at->copy()->addWeeks(2));
        if($date == 2) {
            $discord->removeMember($a->discordData->discord_id);
            $applicant->delete($a->id);
        }
    }
})->describe('Delete all applicants after 2 weeks of deadline');

Artisan::command('applicant:left', function () {
    $discord = resolve('App\Services\DiscordApi');
    $applicant = resolve('App\Services\ApplicantService');

    $applicants = Applicant::where('approved', false)->where('invited', false)->where('denied', false)->get();

    foreach($applicants as $a) {
        $id = $a->discordData->discord_id;

        $disc = $discord->getMember($id);
        if(!$disc) {
            $applicant->delete($a);
        }
    }
})->describe('Remove all applicants who left discord');

Artisan::command('members:renew', function () {
    Member::truncate();

    $api = resolve('App\Services\TwitchApi');

    $data = $api->getKraken('teams/tsaph');

    foreach($data->users as $d) {
        Member::updateOrCreate(
            ['twitch_id' => $d->_id],
            ['username' => $d->display_name, 'avatar' => $d->logo]
        );
    }
});
