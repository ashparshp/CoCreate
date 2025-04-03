<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function login()
    {
        return view('login.login');
    }
    
    public function checkuser(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        
        $user = User::userexists($username, $password);

        if (!$user) {
            return redirect()->route('users.login')->with('error', 'Invalid credentials');
        }

        return redirect()->route('users.dashboard');
    }
    
    public function dashboard()
    {
        return view('dashboard');
    }
}

