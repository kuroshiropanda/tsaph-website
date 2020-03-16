<?php

namespace App\Http\Controllers;

use App\Member;

class MembersController extends Controller
{
    public function index()
    {
        $members = Member::all();

        return view('admin.members', [
            'members' => $members
        ]);
    }

    public function memberlist()
    {
        $members = Member::all();

        return view('home.members', compact('members'));
    }
}
