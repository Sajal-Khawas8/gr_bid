<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function create()
    {
        return view("pages.client.register");
    }

    public function store(Request $req)
    {
        $attributes = $req->validate([
            "name" => ["bail", "required", "min:3", "max:50", "regex:/^[a-zA-Z\s]*$/"],
            "email" => ["bail", "required", "email", "unique:users,email"],
            "profilePicture" => ['image'],
            "address" => ["bail", "required", "min:3"],
            "password" => ["bail", "required", Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()->rules(["max:16"]), "confirmed"]
        ]);
        $userData = [
            "name" => $attributes["name"],
            "email" => $attributes["email"],
            "password" => $attributes["password"],
            "address" => $attributes["address"],
        ];
        if ($req->hasFile("profilePicture")) {
            $userData["image"] = $attributes["profilePicture"]->store("users");
        }
        $user = User::create($userData)->assignRole("user");
        Auth::login($user, true);
        return redirect()->intended()->with("success", "Your account has been created Successfully!");
    }
}
