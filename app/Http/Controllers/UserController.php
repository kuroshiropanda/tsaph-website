<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(Auth::id() !== $user->id)
        {
            return redirect()->route('user.edit', ['user' => Auth::id()]);
        }
        else {
            return view('admin.profile', compact('user'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'string',
            'username' => 'string',
            'email' => 'email',
            'password' => 'required|password:web'
        ]);

        $user->name = $request['name'];
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->save();

        return redirect()->route('admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users');
    }

    public function password(User $user)
    {
        if(Auth::id() !== $user->id)
        {
            return redirect()->route('user.password', ['user' => Auth::id()]);
        }
        else
        {
            return view('admin.change_password');
        }
    }

    public function updatePassword(User $user, Request $request)
    {
        $request->validate([
            'password' => 'confirmed',
            'old_password' => 'password:web'
        ]);

        $user->password = Hash::make($request['password']);
        $user->save();

        return redirect()->route('admin');
    }

    public function updateRole(User $user, Request $request)
    {
        $user->syncRoles($request->roles);
        $user->api_token = \Str::random(80);
        $user->save();

        return redirect()->route('users');
    }

    public function userapi(Request $request)
    {
        return $request->user();
    }
}
