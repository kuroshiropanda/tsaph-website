<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Applicants;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;

class ApplyController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DISCORD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'unique:applicant'],
            'answer' => ['required', 'string', 'min:10']
        ]);
    }

    protected function apply(Request $request)
    {
        \App\Applicant::create([
            'twitch_id' => $request['id'],
            'username' => $request['username'],
            'email' => $request['email'],
            'name' => $request['name']
        ]);
        // \App\Application::create($request);
        // \App\Answer::create($request);

        $c = 0;

        foreach($request['answer'] as $a)
        {
            $c++;
            $ans = \App\Answer::create(['answer' => $a]);
            \App\Application::create(['applicant_id' => $request['id'], 'answer_id' => $ans['id'], 'question_id' => $c]);
        }

        return redirect('https://discord.gg/pkuRuKe');
        // return dd($request);
    }
}
