<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function checkuser($username, $password)
    {
        $user = User::userexists($name, $password);

        if (!$user) {
            abort(404);
        }

        return view('users.login', compact('users'));
    }
}
