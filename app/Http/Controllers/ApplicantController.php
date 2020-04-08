<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TwitchApi;
use App\Applicant;
use App\Http\Requests\ApplicantStore;
use Auth;
use Socialite;

class ApplicantController extends Controller
{
    protected $twitchapi;

    public function __construct(TwitchApi $twitchapi)
    {
        $this->twitchapi = $twitchapi;
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
        $token = (string) $request->cookie('token');

        $user = Socialite::driver('twitch')->userFromToken($token);

        $id = $user->getId();
        $username = $user->user['login'];
        $avatar = $user->avatar;
        $email = $user->getEmail();

        $questions = \App\Question::all();
        $types = \App\Type::all();

        $member = \App\Member::find($id);
        $applicant = \App\Applicant::where('twitch_id', $id)->first();

        if($member)
        {
            return view('application', [
                'type' => 'member',
                'alert' => 'member ka na tanga'
            ]);
        }
        elseif($applicant)
        {
            return view('application', [
                'type' => 'applicant',
                'alert' => 'nag apply ka na. chill ka lang. wak bobo'
            ]);
        }
        else
        {
            return view('apply', [
                'id' => $id,
                'avatar' => $avatar,
                'username' => $username,
                'email' => $email,
                'questions' => $questions,
                'types' => $types
            ]);
        }
    }

    public function store(Request $request)
    {
        $applicant = Applicant::where('twitch_id', $request->id)->first();

        if (empty($applicant)) {
            \DB::transaction(function () use ($request) {
                $app = new Applicant;
                $app->twitch_id = $request->id;
                $app->avatar = $request->avatar;
                $app->username = $request->username;
                $app->email = $request->email;
                $app->name = $request->name;
                // $app->discord = $request->discord;

                $app->save();

                for ($i = 0; $i < count($request->question_id); $i++) {
                    $a = $request->answer[$i];
                    $q = \App\Question::find($request->question_id[$i])->id;
                    $aid = \App\Answer::create([
                        'answer' => $a
                    ]);

                    $app->answers()->attach($aid, ['question_id' => $q]);
                }

                $app->types()->attach($request->checkbox);
            });
        }

        $app = Applicant::where('twitch_id', $request->id)->first();

        $cookie = cookie('applicant', $app->id, 60);

        return redirect()->route('discord.auth')->cookie($cookie);
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
        if (isset($request->username)) {
            $data = $this->twitchapi->get('users', [
                'query' => [
                    'login' => $request->username
                ]
            ]);

            $applicant->twitch_id = $data->data[0]->id;
            $applicant->username = $data->data[0]->login;
            $applicant->avatar = $data->data[0]->profile_image_url;
        }

        if (isset($request->discord)) {
            $applicant->discord = $request->discord;
        }

        $applicant->save();

        return redirect()->route('applicants');
    }

    public function destroy(Applicant $applicant, Request $request)
    {
        $user = $request->user();
        if ($user->hasRole('super admin')) {
            \DB::transaction(function () use ($applicant) {
                foreach ($applicant->answers as $ans) {
                    $ans->delete();
                }

                $applicant->delete();
            });
        }

        return redirect()->route('applicants');
    }

    public function processApplicant(Applicant $applicant, Request $request)
    {
        if ($request->update === 'approve') {
            $applicant->approved = true;
            $applicant->user_id = Auth::id();
            $applicant->save();
            if ($applicant->denied === 1) {
                $applicant->denied = false;
            }

            return redirect()->route('applicants');
        } elseif ($request->update === 'deny') {
            if ($applicant->approved === 0) {
                \DB::transaction(function () use ($applicant, $request) {
                    $applicant->denied = true;
                    $applicant->user_id = Auth::id();
                    $applicant->save();

                    $applicant->reason()->create([
                        'reason' => $request->reason
                    ]);
                });
            }

            return redirect()->route('applicants');
        }
    }

    public function updateData(Applicant $applicant)
    {
        $data = $this->twitchapi->get('users', [
            'query' => [
                'id' => $applicant->twitch_id
            ]
        ]);

        $applicant->username = $data->data[0]->login;
        $applicant->avatar = $data->data[0]->profile_image_url;
        $applicant->save();

        return redirect()->route('applicants');
    }
}
