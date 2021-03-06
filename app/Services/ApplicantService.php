<?php

namespace App\Services;

use DB;
use Auth;
use Socialite;
use App\Applicant;
use App\Discord;
use App\Services\DiscordApi;

class ApplicantService
{
    protected $discord;

    public function __construct(DiscordApi $discord)
    {
        $this->discord = $discord;
    }

    public function add($data)
    {
        $applicant = Applicant::where('twitch_id', $data->id)->first();

        if (empty($applicant)) {
            DB::transaction(function () use ($data) {
                $app = new Applicant;
                $app->twitch_id = $data->id;
                $app->avatar = $data->avatar;
                $app->username = $data->username;
                $app->email = $data->email;
                $app->name = $data->name;
                // $app->discord = $data->discord;

                $app->save();

                for ($i = 0; $i < count($data->question_id); $i++) {
                    $a = $data->answer[$i];
                    $q = \App\Question::find($data->question_id[$i])->id;
                    $aid = \App\Answer::create([
                        'answer' => $a
                    ]);

                    $app->answers()->attach($aid, ['question_id' => $q]);
                }

                $app->types()->attach($data->checkbox);

                $discordToken = $data->cookie('discord');

                $user = Socialite::driver('discord')->userFromToken($discordToken);

                $id = $user->getId();
                $username = $user->getNickname();
                $avatar = $user->getAvatar();
                $email = $user->getEmail();

                $token = $user->token;

                $discordDup = \App\Discord::where('discord_id', $id)->first();

                if (empty($discordDup)) {
                    $app->discordData()->create([
                        'discord_id' => $id,
                        'avatar' => $avatar,
                        'username' => $username,
                        'email' => $email,
                        'token' => $token
                    ]);
                }

                $discord = $this->discord->getMember($id);

                if ($discord) {
                    $this->discord->memberApplicant($id);
                } else {
                    $this->discord->addMember($id, $token);
                }

                $this->discord->newApplicant($app);
            });
        }
    }

    public function approve(Applicant $applicant)
    {
        if ($applicant->approved === 0) {
            $applicant->approved = true;
            $applicant->user_id = Auth::id();
            $applicant->save();
            if ($applicant->denied === 1) {
                $applicant->denied = false;
            }

            $discord = $this->discord->getId($applicant);

            $this->discord->updateMember($applicant, $discord);
            $this->discord->approvedLog($applicant);
            $this->discord->sendDM($applicant, $discord);
        }
    }

    public function deny(Applicant $applicant, $reason)
    {
        if ($applicant->approved === 0) {
            DB::transaction(function () use ($applicant, $reason) {
                $applicant->denied = true;
                $applicant->user_id = Auth::id();
                $applicant->save();

                $applicant->reason()->create([
                    'reason' => $reason
                ]);
            });
        }

        $this->discord->deniedLog($applicant);
    }

    public function updateTwitch(Applicant $applicant, $data)
    {
        $id = $data['data'][0]['id'];
        if ($applicant->twitch_id !== $id) {
            $applicant->twitch_id = $id;
        }
        $applicant->username = $data['data'][0]['login'];
        $applicant->avatar = $data['data'][0]['profile_image_url'];

        $applicant->save();

        $discordId = $this->discord->getId($applicant);

        $this->discord->updateUsername($applicant, $discordId);
    }

    public function updateDiscord(Applicant $applicant, $discordId)
    {
        $dup = Discord::where('discord_id', $discordId)->first();
        if ($dup) {
            return false;
        }
        $id = (int) $discordId;
        $discord = $this->discord->memberInfo($id);
        $username = $discord->username . "#" . $discord->discriminator;
        $avatar = url("https://cdn.discordapp.com/avatars/{$discord->id}/{$discord->avatar}.jpg");
        $applicant->discordData()->updateOrCreate(
            [ 'applicant_id' => $applicant->id ],
            [
                'discord_id' => $id,
                'username' => $username,
                'avatar' => $avatar
            ]
        );
        $applicant->discord = $username;

        $applicant->save();

        return true;
    }

    public function delete(Applicant $applicant)
    {
        try {
            DB::transaction(function () use ($applicant) {
                $applicant->discordData()->delete();
                $applicant->answers()->delete();
                $applicant->answers()->detach();
                $applicant->types()->detach();
                $applicant->reason()->delete();

                $applicant->delete();
            });
        } catch (Throwable $e) {
            report($e);
            return false;
        }

        return true;
    }
}
