<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
}
