<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'unique:users|required|max:50',
            'password' => 'required|same:password_confirmation',
            'password_confirmation' => 'required'
        ]);

        $username = $request->name;
        $password = $request->password;
        DB::table('users')
            ->insert([
                'name' => $username,
                'password' => Hash::make($password)]);
        return redirect()->route('home');
    }

    public function login(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $userdata = array(
            'name' => $request->name,
            'password' => $request->password
        );

        if (Auth::attempt($userdata)) {
            return redirect()->route('home');
        } else {
            return redirect()->route('login');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
