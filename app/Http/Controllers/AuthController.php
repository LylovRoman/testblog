<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check())
        {
            return redirect('/posts');
        }
        return view('login');
    }

    public function showRegister()
    {
        if (Auth::check())
        {
            return redirect('/posts');
        }
        return view('register');
    }

    public function login(Request $request)
    {
        if(($user = User::where('name', $request->name)->first()) && ($user->password === $request->password)) {
            Auth::login($user);
            return redirect('/posts');
        }
        return redirect('/login')->withErrors([
            'login' => 'Неправильный логин или пароль'
        ]);
    }

    public function register(Request $request) {
        if(($user = User::where('name', $request->name)->first())) {
            return redirect('/register')->withErrors([
                'login' => 'Имя занято'
            ]);
        }
        User::insert([
            'name' => $request->name,
            'password' => $request->password
        ]);
        return redirect('/login');
    }

    public  function logout()
    {
        Auth::logout();
        return redirect('/posts');
    }
}
