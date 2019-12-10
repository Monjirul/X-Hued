<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class login extends Controller
{
    public function index()
    {
    	return view('login',['loggedUser' => session('loggedUser')]);
    }

    public function verify(Request $request)
    {
    	$email = $request->email;
    	$password = $request->password;

    	$user = new User;

    	$u = $user->where([
					       'email' => $email,
					       'password' => $password
						])->first();

    	if($u != null)
    	{
    		$temp = $request->session()->put('loggedUser', $u);

    		return redirect()->route('home');
    	}
    	else
    	{
    		return view('login');
    	}
    }
}
