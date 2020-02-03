<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ApplicantController extends Controller
{
    public function create(Request $request)
    {

        \DB::transaction(function() use ($request) {
            $app = new \App\Applicant;
            $app->twitch_id = $request['id'];
            $app->avatar = $request['avatar'];
            $app->username = $request['username'];
            $app->email = $request['email'];
            $app->name = $request['name'];
            $app->discord = $request['discord'];

            $app->save();

            for($i = 0; $i < count($request['question_id']); $i++)
            {
                $a = $request['answer'][$i];
                $q = \App\Question::find($request['question_id'][$i])->id;
                $aid = \App\Answer::create([
                    'answer' => $a
                ]);

                $app->answers()->attach($aid, ['question_id' => $q]);
            }

            $app->types()->attach($request['checkbox']);
        });

        return redirect('https://discord.gg/wrwgGH4');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $applicant = \App\Applicant::find($id);

        $answers = $applicant->answers()
            ->get();

        $types = $applicant->types()->get();

        return view('admin.applicant', [
            'applicant' => $applicant,
            'answers' => $answers,
            'types' => $types
        ]);
    }

    public function update($id, Request $request)
    {
        $applicant = \App\Applicant::find($id);
        if($request['update'] == 'approve')
        {
            $applicant->approved = true;
            $applicant->user_id = Auth::id();
            $applicant->save();

            return redirect()->route('applicants');
        }
        else if($request['update'] == 'deny')
        {
            \DB::transaction(function() use ($applicant, $request) {
                $applicant->denied = true;
                $applicant->user_id = Auth::id();
                $applicant->save();

                $applicant->reason()->create([
                    'reason' => $request['reason']
                ]);
            });

            return redirect()->route('applicants');
        }
        else
        {
            $applicant->invited = true;
            $applicant->save();

            // \App\Member::create([
            //     'twitch_id' => $applicant->twitch_id,
            //     'username' => $applicant->username,
            //     'avatar' => $applicant->avatar
            // ]);

            return redirect()->route('approved');
        }
    }

    public function inviteAll()
    {
        \App\Applicant::where('approved', true)
            ->where('invited', false)
            ->update(['invited', true]);

        return redirect('/approved');
    }
}
