<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\User;
use Spatie\Permission\Models\Role;

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

    public function users()
    {
        $users = User::paginate(10);
        $roles = Role::all();

        return view('admin.users', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function approved()
    {
        $approved = \App\Applicant::where('approved', true)
            ->with('user')
            ->paginate(10);

        return view('admin.approved', [
            'approved' => $approved
        ]);
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

    public function applicants()
    {
        $applicants = \App\Applicant::where('approved', false)
            ->where('denied', false)
            ->where('invited', false)
            ->get();

        return view('admin.applicants', [
            'applicants' => $applicants
        ]);
    }
}
