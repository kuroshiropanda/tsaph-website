<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;
use App\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        $roles = Role::all();

        return view('admin.users', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

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

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'string',
            'username' => 'string',
            'email' => 'email',
            'password' => 'required|password:web'
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('admin');
    }

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

        $user->password = Hash::make($request->password);
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
}
