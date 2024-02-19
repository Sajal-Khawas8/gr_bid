<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function create()
    {
        return view("pages.shared.login");
    }

    public function store(Request $req)
    {
        $credentials = $req->validate([
            "email" => ["bail", "required", "email", "exists:users,email"],
            "password" => ["required"]
        ]);

        if (!Auth::attempt($credentials, true)) {
            throw ValidationException::withMessages([
                "email" => "Your Email Address and Password couldn't be verified",
                "password" => "Your Email Address and Password couldn't be verified"
            ]);
        }
        $req->session()->regenerate();
        return redirect()->intended(auth()->user()->hasRole('user') ? '/' : '/dashboard')->with("success", "Welcome back, " . auth()->user()->name . "!");
    }

    public function destroy(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('/')->with("success", "Logged Out Successfully!");
    }
}
