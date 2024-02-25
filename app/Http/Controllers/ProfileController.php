<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\UserLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        return view("pages.admin.settings");
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $this->authorize("update", auth()->user());
        return view("pages.admin.edit-settings");
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $req): RedirectResponse
    {
        $this->authorize("update", auth()->user());
        $user = auth()->user();
        $attributes = $req->validate([
            "name" => ["bail", "nullable", "min:3", "max:50", "regex:/^[a-zA-Z\s]*$/"],
            "email" => ["bail", "nullable", "email", Rule::unique(User::class)->ignore($user)],
            "profilePicture" => ['image'],
            "address" => ["nullable", "min:3"],
            "current_password" => ["bail", "required", "current_password"],
            "password" => ["bail", "required", Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()->rules(["max:16"])]
        ]);
        $userData = [
            "name" => $attributes["name"] ?? $user->name,
            "email" => $attributes["email"] ?? $user->email,
            "address" => $attributes["address"] ?? $user->address,
            "password" => $attributes["password"],
        ];

        if ($req->hasFile("profilePicture")) {
            if (empty($user->image)) {
                $user->image()->create([
                    "url" => $attributes["profilePicture"]->store("users")
                ]);
            } else {
                Storage::delete($user->image->url);
                $user->image()->update([
                    "url" => $attributes["profilePicture"]->store("users")
                ]);
            }
        }

        $user->update($userData);
        return redirect("/dashboard/settings")->with("success", "Your data has been updated Successfully!");
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $this->authorize("delete", auth()->user());
        $user = auth()->user()->loadCount(["items", "events"]);
        if ($user->items_count || $user->events_count) {
            return back()->with("error", "You can't delete your account because you have items or events!");
        }

        Auth::logout();
        UserLocation::where("user_id", $user->uuid)->delete();
        Storage::delete($user->image?->url);
        $user->image()->delete();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
