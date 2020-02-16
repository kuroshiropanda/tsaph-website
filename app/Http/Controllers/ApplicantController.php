<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Applicant;

class ApplicantController extends Controller
{
    public function create(Request $request)
    {
        \DB::transaction(function() use ($request) {
            $app = new Applicant;
            $app->twitch_id = $request->id;
            $app->avatar = $request->avatar;
            $app->username = $request->username;
            $app->email = $request->email;
            $app->name = $request->name;
            $app->discord = $request->discord;

            $app->save();

            for($i = 0; $i < count($request->question_id); $i++)
            {
                $a = $request->answer[$i];
                $q = \App\Question::find($request->question_id[$i])->id;
                $aid = \App\Answer::create([
                    'answer' => $a
                ]);

                $app->answers()->attach($aid, ['question_id' => $q]);
            }

            $app->types()->attach($request->checkbox);
        });

        return redirect()->route('interview');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        if($request->update === 'approve')
        {
            $applicant->approved = true;
            $applicant->user_id = Auth::id();
            $applicant->save();
            if($applicant->denied === 1)
            {
                $applicant->denied = false;
            }

            return redirect()->route('applicants');
        }
        else if($request->update === 'deny')
        {
            if($applicant->approved === 0)
            {
                \DB::transaction(function() use ($applicant, $request) {
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
        else
        {
            if($applicant->approved === 1)
            {
                $applicant->invited = true;
                $applicant->save();
            }

            return redirect()->route('approved');
        }
    }

    public function destroy(Applicant $applicant, Request $request)
    {
        $user = $request->user();
        if($user->hasRole('super admin'))
        {
            \DB::transaction(function() use ($applicant) {
                foreach($applicant->answers as $ans) {
                    $ans->delete();
                }

                $applicant->delete();
            });
        }

        return redirect()->route('applicants');
    }

    public function updateData(Request $request)
    {

    }

    public function inviteAll()
    {
        Applicant::where('approved', true)
            ->where('invited', false)
            ->update(['invited', true]);

        return redirect()->route('approved');
    }
}
