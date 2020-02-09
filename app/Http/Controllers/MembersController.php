<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MembersController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach($request['data'] as $data)
        {
            $member = Member::updateOrCreate(
                ['twitch_id' => $data->twitch_id],
                ['username' => $data->username, 'avatar' => $data->avatar]
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $client = new Client([
            'base_uri' => 'https://api.twitch.tv/kraken/',
            'decode_content' => true,
            'headers' => [
                'Client-ID' => env('TWITCH_KEY'),
                'Accept' => 'application/vnd.twitchtv.v5+json'
            ]
        ]);

        $response = $client->request('GET', 'teams/tsaph');
        $body = $response->getBody()->getContents();
        $data = json_decode($body, true);

        foreach($data['users'] as $d)
        {
            $member = Member::updateOrCreate(
                ['twitch_id' => $d['_id']],
                ['username' => $d['display_name'], 'avatar' => $d['logo']]
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        //
    }
}
