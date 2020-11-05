<?php

namespace App\Services;

use RestCord\DiscordClient;
use App\Applicant;
use Throwable;

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

    public function feedback($msg)
    {
        $this->discord->channel->createMessage([
            'channel.id' => 701656125745004555,
            'embed' => [
                'description' => $msg,
                'color' => 16777215,
                'timestamp' => now()->toISOString()
            ]
        ]);
    }

    public function newApplicant(Applicant $applicant)
    {
        $this->discord->channel->createMessage([
            'channel.id' => $this->channel,
            'embed' => [
                "color" => 9520895,
                "timestamp" => $applicant->created_at->toISOString(),
                "thumbnail" => [
                    "url" => $applicant->discordData->avatar
                ],
                "author" => [
                    "name" => $applicant->username,
                    "url" => url("https://twitch.tv/{$applicant->username}"),
                    "icon_url" => $applicant->avatar
                ],
                "fields" => [
                    [
                        "name" => "Name",
                        "value" => $applicant->name
                    ],
                    [
                        "name" => "Discord",
                        "value" => $applicant->discordData->username
                    ],
                    [
                        "name" => "link to application form",
                        "value" => route('applicant.show', ['applicant' => $applicant->username])
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
            'access_token' => (string) $token,
            'roles' => [
                671184968386609183
            ]
        ]);
    }

    public function removeMember($id)
    {
        try {
            $this->discord->guild->removeGuildMember([
                'guild.id' => $this->guild,
                'user.id' => (int) $id
            ]);
        } catch (Throwable $e) {
            report($e);
        }
    }

    public function getMember($id)
    {
        try {
            $this->discord->guild->getGuildMember([
                'guild.id' => $this->guild,
                'user.id' => (int) $id
            ]);
        } catch (Throwable $e) {
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

    public function updateMember(Applicant $applicant, $discord)
    {
        return $this->discord->guild->modifyGuildMember([
            'guild.id' => $this->guild,
            'user.id' => (int) $discord,
            'nick' => $applicant->username,
            'roles' => [
                504770636149817344
            ]
        ]);
    }

    public function updateUsername(Applicant $applicant, $discord)
    {
        return $this->discord->guild->modifyGuildMember([
            'guild.id' => $this->guild,
            'user.id' => (int) $discord,
            'nick' => $applicant->username
        ]);
    }

    public function approvedLog(Applicant $applicant)
    {
        return $this->discord->channel->createMessage([
            'channel.id' => $this->channel,
            'embed' => [
                'title' => 'Approved',
                'color' => 65280,
                'timestamp' => $applicant->updated_at->toISOString(),
                'thumbnail' => [
                    'url' => $applicant->avatar
                ],
                'fields' => [
                    [
                        'name' => 'username',
                        'value' => $applicant->username
                    ],
                    [
                        'name' => 'discord',
                        'value' => $applicant->discordData->username
                    ],
                    [
                        'name' => 'processed by',
                        'value' => $applicant->user->username
                    ]
                ]
            ]
        ]);
    }

    public function deniedLog(Applicant $applicant)
    {
        $reason = $applicant->reason()->latest()->first();

        return $this->discord->channel->createMessage([
            'channel.id' => $this->channel,
            'embed' => [
                'title' => 'Denied',
                'color' => 16711680,
                'timestamp' => $applicant->updated_at->toISOString(),
                'thumbnail' => [
                    'url' => $applicant->avatar
                ],
                'fields' => [
                    [
                        'name' => 'twitch',
                        'value' => $applicant->username
                    ],
                    [
                        'name' => 'discord',
                        'value' => $applicant->discordData->username
                    ],
                    [
                        'name' => 'processed by',
                        'value' => $applicant->user->username
                    ],
                    [
                        'name' => 'reason',
                        'value' => $reason->reason
                    ]
                ]
            ]
        ]);
    }

    public function leaveLog(Applicant $applicant)
    {
        return $this->discord->channel->createMessage([
            'channel.id' => 715493567333793812,
            'embed' => [
                'title' => 'Applicant Left Discord',
                'color' => 13113625,
                'timestamp' => $applicant->updated_at->toISOString(),
                'thumbnail' => [
                    'url' => $applicant->avatar
                ],
                'fields' => [
                    [
                        'name' => 'Name',
                        'value' => $applicant->name
                    ],
                    [
                        'name' => 'twitch',
                        'value' => $applicant->username
                    ],
                    [
                        'name' => 'discord',
                        'value' => $applicant->discordData->username
                    ]
                ]
            ]
        ]);
    }

    public function sendDM(Applicant $applicant, $discord)
    {
        try {
            $channel = $this->discord->user->createDm([
                'recipient_id' => (int) $discord
            ]);

            $this->discord->channel->createMessage([
                'channel.id' => (int) $channel->id,
                'embed' => [
                    'description' => "Hi {$applicant->username},\n\nWelcome to Twitch Sana All Philippines!\n\nPlease read this [click here](https://docs.google.com/document/d/1qO4sPEsWpKJvlduq_OE6izyl8IHFzvVf7NVAeqPa2UA/)\n\nHere are our community socials\n[Facebook Group](https://facebook.com/groups/twitchsaph/)\n[Facebook Page](https://facebook.com/TSAPHofficial)\n[Reddit](https://reddit.com/r/tsaph/)\nand don't be shy to start a conversation with any of the TSAPH members.\n\nSee you around!\nTwitch Sana All PH Team",
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
        } catch (Throwable $e) {
            report($e);
        }
    }

    public function getId(Applicant $applicant)
    {
        if (empty($applicant->discordData)) {
            $members = $this->discord->guild->listGuildMembers([
                'guild.id' => $this->guild,
                'limit' => 500
            ]);

            foreach ($members as $m) {
                $discord = $m->user->username . "#" . $m->user->discriminator;
                if ($discord == $applicant->discord) {
                    return $m->user->id;
                }
            }
        } else {
            return $applicant->discordData->discord_id;
        }
    }

    public function memberInfo($id)
    {
        return $this->discord->user->getUser([
            'user.id' => (int) $id
        ]);
    }
}
