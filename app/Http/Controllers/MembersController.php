<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use App\Services\TwitchApi;

class MembersController extends Controller
{

    protected $twitchapi;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TwitchApi $twitchapi)
    {
        $this->twitchapi = $twitchapi;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::all();

        return view('admin.members', [
            'members' => $members
        ]);
    }

    public function update()
    {
        $data = $this->twitchapi->getKraken('teams/tsaph');

        foreach($data->users as $d)
        {
            $app = \App\Applicant::where('twitch_id', $d->_id)
                                ->where('invited', false)
                                ->first();
            if($app)
            {
                $app->invited = true;
                $app->save();
            }

            $member = Member::updateOrCreate(
                ['twitch_id' => $d->_id],
                ['username' => $d->display_name, 'avatar' => $d->logo]
            );
        }
    }

    public function memberlist()
    {
        $members = Member::all();

        return view('home.members', compact('members'));
    }
}
