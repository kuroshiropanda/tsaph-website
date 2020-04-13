<?php

namespace App\Services;

use RestCord\DiscordClient;
use App\Applicant;
use Exception;

class DiscordApi
{
    public function __construct()
    {
        $this->discord = new DiscordClient(['token' => config('services.discord.bot_token')]);
        $this->guild = 504692743524843521;
        $this->channel = 675839442199773204;
    }

    public function sendMessage($msg)
    {
        $this->discord->channel->createMessage([
            'channel.id' => $this->channel,
            'content' => $msg
        ]);
    }

    public function newApplicant($applicant)
    {
        $app = Applicant::find($applicant);

        $this->discord->channel->createMessage([
            'channel.id' => $this->channel,
            'embed' => [
                "color" => 9520895,
                "timestamp" => $app->created_at->toISOString(),
                "thumbnail" => [
                    "url" => $app->discordData->avatar
                ],
                "author" => [
                    "name" => $app->username,
                    "url" => url("https://twitch.tv/{$app->username}"),
                    "icon_url" => $app->avatar
                ],
                "fields" => [
                    [
                        "name" => "Name",
                        "value" => $app->name
                    ],
                    [
                        "name" => "Discord",
                        "value" => $app->discord
                    ],
                    [
                        "name" => "link to application form",
                        "value" => route('applicant', ['applicant' => $app->id])
                    ]
                ]
            ]
        ]);
    }

    public function addMember($id, $token)
    {
        return $this->discord->guild->addGuildMember([
            'guild.id' => $this->guild,
            'user.id' => (int) $id,
            'access_token' => $token,
            'roles' => [
                671184968386609183
            ]
        ]);
    }

    public function getMember($id)
    {
        try {
            $this->discord->guild->getGuildMember([
                'guild.id' => $this->guild,
                'user.id' => (int) $id
            ]);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function memberApplicant($id)
    {
        return $this->discord->guild->modifyGuildMember([
            'guild.id' => $this->guild,
            'user.id' => (int) $id,
            'roles' => [
                671184968386609183
            ]
        ]);
    }

    public function updateMember($id, $discord)
    {
        $applicant = Applicant::find($id);

        return $this->discord->guild->modifyGuildMember([
            'guild.id' => $this->guild,
            'user.id' => (int) $discord,
            'nick' => $applicant->username,
            'roles' => [
                504770636149817344
            ]
        ]);
    }

    public function approvedLog($id)
    {
        $app = Applicant::find($id);

        return $this->discord->channel->createMessage([
            'channel.id' => $this->channel,
            'embed' => [
                'title' => 'Approved',
                'color' => 65280,
                'timestamp' => $app->updated_at->toISOString(),
                'thumbnail' => [
                    'url' => $app->avatar
                ],
                'fields' => [
                    [
                        'name' => 'username',
                        'value' => $app->username
                    ],
                    [
                        'name' => 'discord',
                        'value' => $app->discord
                    ],
                    [
                        'name' => 'processed by',
                        'value' => $app->user->username
                    ]
                ]
            ]
        ]);
    }

    public function deniedLog($id)
    {
        $app = Applicant::find($id);

        $reason = $app->reason()->latest()->first();

        return $this->discord->channel->createMessage([
            'channel.id' => $this->channel,
            'embed' => [
                'title' => 'Denied',
                'color' => 16711680,
                'timestamp' => $app->updated_at->toISOString(),
                'thumbnail' => [
                    'url' => $app->avatar
                ],
                'fields' => [
                    [
                        'name' => 'twitch',
                        'value' => $app->username
                    ],
                    [
                        'name' => 'discord',
                        'value' => $app->discord
                    ],
                    [
                        'name' => 'processed by',
                        'value' => $app->user->username
                    ],
                    [
                        'name' => 'reason',
                        'value' => $reason->reason
                    ]
                ]
            ]
        ]);
    }

    public function sendDM($id, $discord)
    {
        $app = Applicant::find($id);

        try {
            $channel = $this->discord->user->createDm([
                'recipient_id' => (int) $discord
            ]);

            $this->discord->channel->createMessage([
                'channel.id' => (int) $channel->id,
                'embed' => [
                    'description' => "Hi {$app->username},\n\nWelcome to Twitch Sana All Philippines!\n\nPlease read this [click here](https://docs.google.com/document/d/1qO4sPEsWpKJvlduq_OE6izyl8IHFzvVf7NVAeqPa2UA/)\n\nHere are our community socials\n[Facebook Group](https://facebook.com/groups/twitchsaph/)\n[Facebook Page](https://facebook.com/TSAPHofficial)\n[Reddit](https://reddit.com/r/tsaph/)\nand don't be shy to start a conversation with any of the TSAPH members.\n\nSee you around!\nTwitch Sana All PH Team",
                    'color' => 9520895,
                    'footer' => [
                        'icon_url' => url("https://static-cdn.jtvnw.net/jtv_user_pictures/team-tsaph-team_logo_image-17709df6bdb544aab8452aed5791ce1e-600x600.png"),
                        'text' => 'TSAPH'
                    ],
                    'thumbnail' => [
                        'url' => url("https://static-cdn.jtvnw.net/jtv_user_pictures/team-tsaph-team_logo_image-17709df6bdb544aab8452aed5791ce1e-600x600.png")
                    ]
                ]
            ]);
        } catch (Exception $e) {}
    }

    public function getId($id)
    {
        $user = Applicant::find($id);

        if (empty($user->discordData)) {
            $members = $this->discord->guild->listGuildMembers([
                'guild.id' => $this->guild,
                'limit' => 500
            ]);

            foreach ($members as $m) {
                $discord = $m->user->username . "#" . $m->user->discriminator;
                if ($discord == $user->discord) {
                    return $m->user->id;
                }
            }
        } else {
            return $user->discordData->discord_id;
        }
    }

    public function memberInfo($id)
    {
        return $this->discord->user->getUser([
            'user.id' => (int) $id
        ]);
    }
}
