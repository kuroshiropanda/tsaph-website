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
use Throwable;

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

        return view('admin.applicant.index', [
            'applicants' => $applicants
        ]);
    }

    public function create(Request $request)
    {
        $twitchToken = (string) $request->cookie('token');
        $discordToken = (string) $request->cookie('discord');

        try {
            $user = Socialite::driver('twitch')->userFromToken($twitchToken);
            $discord = Socialite::driver('discord')->userFromToken($discordToken);
        } catch (Throwable $e) {
            report($e);
            return redirect()->route('home');
        }

        $id = $user->getId();
        $username = $user->user['login'];
        $avatar = $user->avatar;
        $email = $user->getEmail();
        $discordId = $discord->getNickname();
        $dToken = $discord->token;
        $dId = $discord->getId();

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
            $this->discord->addMember($dId, $dToken);

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

        if (!$captcha['success']) {
            return redirect('form')->withInput()->with('status', 'Captcha failed. Please try again.');
        }

        $this->applicant->add($request);

        return redirect()->route('interview');
    }

    public function show($applicant)
    {
        $applicant = Applicant::where('username', $applicant)->first();
        $answers = $applicant->answers()
            ->get();

        $types = $applicant->types()->get();

        return view('admin.applicant.show', [
            'applicant' => $applicant,
            'answers' => $answers,
            'types' => $types
        ]);
    }

    public function edit(Applicant $applicant)
    {
        return view('admin.applicant.edit', [
            'applicant' => $applicant
        ]);
    }

    public function update(Applicant $applicant, Request $request)
    {
        $captcha = $this->captcha->verify($request['h-captcha-response']);

        if (!$captcha['success']) {
            return back()->with('status', 'Captcha failed. Please try again.');
        }

        if ($applicant->username !== $request->input('twitchUsername')) {
            $data = $this->twitchapi->getUserByLogin($request->input('twitchUsername'));
            $this->applicant->updateTwitch($applicant, $data);
        } elseif ($applicant->twitch_id !== $request->input('twitchId')) {
            $data = $this->twitchapi->getUserById($request->input('twitchId'));
            $this->applicant->updateTwitch($applicant, $data);
        }

        if ($applicant->discordData->discord_id !== $request->input('discordId')) {
            $dis = $this->applicant->updateDiscord($applicant, $request->input('discordId'));
            if (!$dis) {
                return redirect()->route('applicant.edit', ['applicant' => $applicant->id])->with('status', 'Duplicate Discord ID');
            }
        }

        return redirect()->route('applicant.show', ['applicant' => $applicant->username]);
    }

    public function destroy(Applicant $applicant, Request $request)
    {
        $user = $request->user();
        if ($user->hasRole('super admin')) {
            $discordId = $this->discord->getId($applicant);

            $del = $this->applicant->delete($applicant);
            if ($del && $request->boolean('kick')) {
                $this->discord->removeMember($discordId);
            }
        }

        return redirect()->route('applicant.index');
    }

    public function processApplicant(Applicant $applicant, Request $request)
    {
        $request->validate([
            'h-captcha-response' => 'required'
        ]);

        $captcha = $this->captcha->verify($request['h-captcha-response']);

        if (!$captcha['success']) {
            return redirect()->route('applicant.show', ['applicant' => $applicant->id])->withInput()->with('status', 'Captcha failed. Please try again.');
        }

        if ($request->update === 'approve') {
            $this->applicant->approve($applicant);
        } elseif ($request->update === 'deny') {
            $this->applicant->deny($applicant, $request->reason);
        }

        return redirect()->route('applicant.index')->with('status', 'Applicant was processed successfully. ' . $request->update);
    }
}
