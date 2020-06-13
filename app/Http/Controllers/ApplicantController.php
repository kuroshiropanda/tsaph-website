<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TwitchApi;
use App\Applicant;
use App\Http\Requests\StoreApplicant;
use Auth;
use Socialite;
use App\Services\DiscordApi;
use App\Services\HCaptcha;
use App\Services\ApplicantService;
use Exception;

class ApplicantController extends Controller
{
    protected $twitchapi;
    protected $discord;
    protected $captcha;
    protected $app;

    public function __construct(TwitchApi $twitchapi, DiscordApi $discord, Hcaptcha $captcha, ApplicantService $app)
    {
        $this->twitchapi = $twitchapi;
        $this->discord = $discord;
        $this->captcha = $captcha;
        $this->applicant = $app;
    }

    public function index()
    {
        $applicants = \App\Applicant::where('approved', false)
            ->where('denied', false)
            ->where('invited', false)
            ->get();

        return view('admin.applicants', [
            'applicants' => $applicants
        ]);
    }

    public function create(Request $request)
    {
        $twitch = (string) $request->cookie('token');
        $discord = (string) $request->cookie('discord');

        try {
            $user = Socialite::driver('twitch')->userFromToken($twitch);
            $discord = Socialite::driver('discord')->userFromToken($discord);
        } catch (Exception $e) {
            return redirect()->route('home');
        }

        $id = $user->getId();
        $username = $user->user['login'];
        $avatar = $user->avatar;
        $email = $user->getEmail();
        $discordId = $discord->getNickname();

        $questions = \App\Question::all();
        $types = \App\Type::all();

        $member = \App\Member::find($id);
        $applicant = \App\Applicant::where('twitch_id', $id)->first();

        if ($member) {
            return view('application', [
                'type' => 'member',
                'alert' => 'member ka na tanga'
            ]);
        } elseif ($applicant) {
            $this->discord->addMember($id, $discord);

            return view('application', [
                'type' => 'applicant',
                'alert' => 'nag apply ka na. chill ka lang. wak bobo'
            ]);
        } else {
            return view('apply', [
                'id' => $id,
                'avatar' => $avatar,
                'username' => $username,
                'discord' => $discordId,
                'email' => $email,
                'questions' => $questions,
                'types' => $types
            ]);
        }
    }

    public function store(StoreApplicant $request)
    {
        $validated = $request->validated();

        $captcha = $this->captcha->verify($validated['h-captcha-response']);

        if ($captcha['success']) {
            $this->applicant->add($request);
        } else {
            return redirect('form')->withInput()->with('status', 'Captcha failed. Please try again.');
        }

        return redirect()->route('interview');
    }

    public function show(Applicant $applicant)
    {
        $answers = $applicant->answers()
            ->get();

        $types = $applicant->types()->get();

        return view('admin.applicant', [
            'applicant' => $applicant,
            'answers' => $answers,
            'types' => $types
        ]);
    }

    public function update(Applicant $applicant, Request $request)
    {
        if ($request->filled('username')) {
            $this->applicant->updateTwitch($applicant, $request->username);
        }

        if ($request->filled('discord')) {
            $this->applicant->updateDiscord($applicant, $request->discord);
        }

        return redirect()->route('applicants');
    }

    public function destroy(Applicant $applicant, Request $request)
    {
        $user = $request->user();
        if ($user->hasRole('super admin')) {
            $del = $this->applicant->delete($applicant);
            if($del) {
                $this->discord->removeMember($applicant->discordData->discord_id);
            }
        }

        return redirect()->route('applicants');
    }

    public function processApplicant(Applicant $applicant, Request $request)
    {
        $request->validate([
            'h-captcha-response' => 'required'
        ]);

        $captcha = $this->captcha->verify($request['h-captcha-response']);

        if($captcha['success']) {
            if ($request->update === 'approve') {
                $this->applicant->approve($applicant);
            } elseif ($request->update === 'deny') {
                $this->applicant->deny($applicant, $request->reason);
            }
        } else {
            return redirect()->route('applicant', ['applicant' => $applicant->id])->withInput()->with('status', 'Captcha failed. Please try again.');
        }

        return redirect()->route('applicants')->with('status', 'Applicant was processed successfully. '.$request->update);
    }

    public function updateData(Applicant $applicant)
    {
        $data = $this->twitchapi->get('users', [
            'query' => [
                'id' => $applicant->twitch_id
            ]
        ]);

        $applicant->username = $data['data'][0]['login'];
        $applicant->avatar = $data['data'][0]['profile_image_url'];
        $applicant->save();

        return redirect()->route('applicants');
    }
}
