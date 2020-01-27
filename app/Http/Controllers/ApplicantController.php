<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ApplicantController extends Controller
{
    public function apply(Request $request)
    {
        // $app = new \App\Applicant;
        // $app->twitch_id = $request['id'];
        // $app->avatar = $request['avatar'];
        // $app->username = $request['username'];
        // $app->email = $request['email'];
        // $app->name = $request['name'];

        // $app->save();

        // for($i = 0; $i < count($request['question_id']); $i++)
        // {
        //     $a = $request['answer'][$i];
        //     $q = \App\Question::find($request['question_id'][$i])->id;
        //     $app->answers()->create([
        //         'answer' => $a,
        //         'question_id' => $q
        //     ]);
        // }

        \DB::transaction(function() use ($request) {
            $app = new \App\Applicant;
            $app->twitch_id = $request['id'];
            $app->avatar = $request['avatar'];
            $app->username = $request['username'];
            $app->email = $request['email'];
            $app->name = $request['name'];

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

        return redirect()->route('discord');
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

        // return dd($answers);

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
            $applicant->denied = true;
            $applicant->user_id = Auth::id();
            $applicant->save();

            return redirect()->route('applicants');
        }
        else
        {
            $applicant->invited = true;
            $applicant->save();

            \App\Member::create([
                'twitch_id' => $applicant->twitch_id,
                'username' => $applicant->username,
                'avatar' => $applicant->avatar
            ]);

            return redirect()->route('approved');
        }
    }

    // public function approve($id, Request $request)
    // {
    //     $applicant = \App\Applicant::find($id);
    //     $applicant->approved = true;
    //     $applicant->user_id = Auth::id();
    //     $applicant->save();

    //     return redirect('/applicants');
    // }

    // public function deny($id, Request $request)
    // {
    //     $applicant = \App\Applicant::find($id);
    //     $applicant->denied = true;
    //     $applicant->user_id = Auth::id();
    //     $applicant->save();

    //     return redirect('/applicants');
    // }

    // public function invite($id)
    // {
    //     $applicant = \App\Applicant::find($id);
    //     $applicant->invited = true;
    //     $applicant->save();

    //     return redirect('/approved');
    // }

    public function inviteAll()
    {
        \App\Applicant::where('approved', true)
            ->where('invited', false)
            ->update(['invited', true]);

        return redirect('/approved');
    }
}
