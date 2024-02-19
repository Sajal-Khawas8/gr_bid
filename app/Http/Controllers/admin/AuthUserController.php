<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class AuthUserController extends Controller
{
    public function show()
    {
        return view("pages.admin.settings");
    }

    public function edit()
    {
        $this->authorize("update", auth()->user());
        return view("pages.admin.edit-settings");
    }

    public function update(Request $req)
    {
        $this->authorize("update", auth()->user());
        $user = auth()->user();
        $attributes = $req->validate([
            "name" => ["bail", "nullable", "min:3", "max:50", "regex:/^[a-zA-Z\s]*$/"],
            "email" => ["bail", "nullable", "email", Rule::unique(User::class)->ignore($user)],
            "profilePicture" => [File::image()],
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
            $userData["image"] = $attributes["profilePicture"]->store("users");
            !empty($user->image) && Storage::delete($user->image);
        }

        $user->update($userData);
        return redirect("/dashboard/settings")->with("success", "Your data has been updated Successfully!");
    }

    public function destroy(Request $req)
    {
        $this->authorize("delete", auth()->user());
        $user=auth()->user()->loadCount(["items", "events"]);
        if ($user->items_count || $user->events_count) {
            return back()->with("error","You can't delete your account because you have items or events!");
        }

        // Logout the user
        auth()->logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();

        $user->delete();
        return redirect("/")->with("success","Your Account has been deleted successfully.");
    }
}
