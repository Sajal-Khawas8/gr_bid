<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            "name" => ["bail", "required", "min:3", "max:50", "regex:/^[a-zA-Z\s]*$/"],
            "email" => ["bail", "required", "email", "unique:users,email"],
            "profilePicture" => ['image'],
            "address" => ["required", "min:3"],
            "password" => ["bail", "required", Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()->rules(["max:16"]), "confirmed"],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('user');

        if ($request->hasFile("profilePicture")) {
            $user->image()->create([
                "url" => $request->file("profilePicture")->store("users")
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME)->with("success", "Welcome " . auth()->user()->name . "! Your account has been created.");
    }
}
