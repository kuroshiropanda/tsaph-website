<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DiscordApi;
use App\Services\HCaptcha;
use App\Feedback;
use App\Http\Requests\StoreFeedback;

class FeedbackController extends Controller
{
    protected $discord;
    protected $captcha;

    public function __construct(DiscordApi $discord, HCaptcha $captcha)
    {
        $this->discord = $discord;
        $this->captcha = $captcha;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedbacks = Feedback::all();

        return view('admin.feedback', compact('feedbacks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFeedback $request)
    {
        $validated = $request->validated();

        $captcha = $this->captcha->verify($validated['h-captcha-response']);

        if($captcha->success) {
            $this->discord->feedback($validated['message']);

            $feedback = new Feedback;
            if($request->has('name')) {
                $feedback->name = $request->name;
            }
            $feedback->message = $validated['message'];
            $feedback->save();
        } else {
            return redirect()->route('contact')->with('status', 'Captcha failed. Please try again.');
        }

        return redirect()->route('contact')->with('status', 'Feedback was submitted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
