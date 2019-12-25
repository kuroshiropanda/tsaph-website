<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('admin');
    }

    public function dashboard()
    {
        $data = \App\Application::all();
        // $questions = \App\Application::all()->get();
        // $ans

        return dd($data);

        // return view('dashboard', $data);
    }

    public function applications()
    {
        $data = \App\Applications::all()->get();

        return dd($data);

        // return view('applications', )
    }
}
