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
    $discordApi = resolve('App\Services\DiscordApi');
    $appService = resolve('App\Services\ApplicantService');

    $applicants = Applicant::all();

    $bar = $this->output->createProgressBar(count($applicants));
    $bar->start();

    foreach ($applicants as $a) {
        $data = $api->get('users', [
            'id' => $a->twitch_id
        ]);

        $discordId = $discordApi->getId($a);

        try {
            $appService->updateTwitch($a, $data);
            $appService->updateDiscord($a, $discordId);
        } catch(Throwable $e) {
            report($e);
            $appService->delete($a);
            $discordApi->removeMember($discordId);
        }

        $bar->advance();
    }

    $bar->finish();
})->describe('Updates applicants data; i.e. avatars, username');

Artisan::command('member:update', function () {
    $api = resolve('App\Services\TwitchApi');

    $data = $api->getKraken('teams/tsaph');

    $bar = $this->output->createProgressBar(count($data['users']));
    $bar->start();

    foreach ($data['users'] as $d) {
        $app = \App\Applicant::where('twitch_id', $d['_id'])
            ->where('invited', false)
            ->first();
        if ($app) {
            $app->invited = true;
            $app->save();
        }

        Member::updateOrCreate(
            ['twitch_id' => $d['_id']],
            ['username' => $d['display_name'], 'avatar' => $d['logo']]
        );

        $bar->advance();
    }

    $bar->finish();
})->describe('Update list of members and their data');

Artisan::command('applicant:deadline', function () {
    $discord = resolve('App\Services\DiscordApi');
    $applicant = resolve('App\Services\ApplicantService');

    $applicants = Applicant::where('approved', false)->where('invited', false)->get();
    $bar = $this->output->createProgressBar(count($applicants));
    $bar->start();

    foreach ($applicants as $a) {
        $date = $a->created_at->diffInWeeks($a->created_at->copy()->addWeeks(2));
        if ($date == 2) {
            $discordId = $discord->getId($a);
            $del = $applicant->delete($a->id);
            if ($del) {
                $discord->removeMember($discordId);
            }
        }

        $bar->advance();
    }

    $bar->finish();
})->describe('Delete all applicants after 2 weeks of deadline');

Artisan::command('applicant:left', function () {
    $discord = resolve('App\Services\DiscordApi');
    $applicant = resolve('App\Services\ApplicantService');

    $applicants = Applicant::where('approved', false)->where('invited', false)->get();

    $bar = $this->output->createProgressBar(count($applicants));
    $bar->start();

    foreach ($applicants as $a) {
        $id = $discord->getId($a);

        $disc = $discord->getMember($id);
        if (!$disc) {
            $discord->leaveLog($a);
            $applicant->delete($a);
        }

        $bar->advance();
    }

    $bar->finish();
})->describe('Remove all applicants who left discord');

Artisan::command('member:renew', function () {
    Member::truncate();

    $api = resolve('App\Services\TwitchApi');

    $data = $api->getKraken('teams/tsaph');

    $bar = $this->output->createProgressBar(count($data['users']));
    $bar->start();

    foreach ($data['users'] as $d) {
        Member::updateOrCreate(
            ['twitch_id' => $d['_id']],
            ['username' => $d['display_name'], 'avatar' => $d['logo']]
        );

        $bar->advance();
    }

    $bar->finish();
})->describe('Truncate members table then updates all list from twitch api');

Artisan::command('applicant:delete', function () {
    $appService = resolve('App\Services\ApplicantService');

    $applicants = Applicant::where('invited', true)->get();

    $bar = $this->output->createProgressBar(count($applicants));
    $bar->start();

    foreach ($applicants as $a) {
        $appService->delete($a);

        $bar->advance();
    }

    $bar->finish();
})->describe('Delete all applicants that has already been invited');
