<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $activity = Activity::orderBy('id', 'desc')->paginate(10);
        return view('home', ['activities' => $activity]);
    }

    public function users()
    {
        $users = User::paginate(10);

        return view('users', ['users' => $users]);
    }

    public function approved()
    {
        $approved = \App\Applicant::where('approved', true)
            ->where('denied', false)
            ->where('invited', false)
            ->with('user')
            ->paginate(10);

        // return dd($approved);

        return view('approved', [
            'approved' => $approved
        ]);
    }

    public function denied()
    {
        $denied = \App\Applicant::where('approved', false)
            ->where('denied', true)
            ->where('invited', false)
            ->with('user')
            ->paginate(10);

        return view('denied', [
            'denied' => $denied
        ]);
    }

    public function applicants()
    {
        $applicants = \App\Applicant::where('approved', false)
            ->where('denied', false)
            ->where('invited', false)
            ->get();

        return view('applicants', [
            'applicants' => $applicants
        ]);
    }

    public function applicant($id)
    {
        $applicant = \App\Applicant::find($id);

        $answers = $applicant->answers()
            ->join('questions', 'answers.question_id', '=', 'questions.id')
            ->get();
        // $applicant = \App\Answer::where('applicant_id', $id)
        //     ->with('applicant')
        //     ->join('questions', 'answers.question_id', '=', 'questions.id')
        //     ->get();

        return view('applicant', [
            'applicant' => $applicant,
            'answers' => $answers
        ]);
    }
}
