<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

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
        return view('admin.index', ['activities' => $activity]);
    }

    public function approved()
    {
        $approved = \App\Applicant::where('approved', true)
            ->where('invited', false)
            ->with('user')
            ->orderBy('updated_at', 'desc')
            ->get();

        $invited = \App\Applicant::where('approved', true)
            ->where('invited', true)
            ->with('user')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.approved', compact('approved', 'invited'));
    }

    public function denied()
    {
        $denied = \App\Applicant::where('approved', false)
            ->where('denied', true)
            ->where('invited', false)
            ->with('user')
            ->with('reason')
            ->paginate(10);

        return view('admin.denied', [
            'denied' => $denied
        ]);
    }
}
