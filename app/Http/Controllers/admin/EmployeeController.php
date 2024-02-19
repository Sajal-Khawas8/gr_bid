<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\User;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::role("employee")->filter()->with('locations')->lazy();
        return view("pages.admin.employees", compact("employees"));
    }

    public function create()
    {
        $this->authorize("create", User::class);

        $locations = Location::lazy();
        if ($locations->count() === 0) {
            return back()->with("error", "Please add atleast one location before adding manager");
        }
        return view("pages.admin.add-employee", compact("locations"));
    }

    public function store(Request $req)
    {
        $this->authorize("create", User::class);

        $attributes = $req->validate([
            "name" => ["bail", "required", "min:3", "max:50", "regex:/^[a-zA-Z\s]*$/"],
            "email" => ["bail", "required", "email", "unique:users,email"],
            "profilePicture" => [File::image()],
            "locations" => ["required"],
            "locations.*" => ["exists:locations,name"],
            "address" => ["required", "min:3"],
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
        $user = User::create($userData)->assignRole('employee');
        foreach ($attributes['locations'] as $location) {
            UserLocation::create([
                'user_id' => $user->uuid,
                'location_name' => Location::where('name', $location)->first()->name
            ]);
        }
        return redirect("/dashboard/employees")->with("success", "New Employee has been registered Successfully!");
    }

    public function edit(User $user)
    {
        $this->authorize("update", $user);
        $user->load("locations");
        $locations = Location::lazy();
        // return $user->locations;
        return view("pages.admin.edit-employee", compact("user", "locations"));
    }

    public function update(Request $req, User $user)
    {
        $this->authorize("update", $user);
        $attributes = $req->validate([
            "name" => ["bail", "nullable", "min:3", "max:50", "regex:/^[a-zA-Z\s]*$/"],
            "email" => ["bail", "nullable", "email", Rule::unique(User::class)->ignore($user)],
            "locations.*" => ["exists:locations,name"],
            "profilePicture" => [File::image()],
            "address" => ["nullable", "min:3"],
        ]);

        $locationsToRemove = $req->locations ?
            $user->locations->pluck('location_name')->diff(collect($req->locations))->values() :
            collect();
        $locationsToAdd = collect($req->locations)
            ->diff($user->locations->pluck('location_name'))->values();

        // Inserting new locations
        foreach ($locationsToAdd ?? [] as $location) {
            UserLocation::create([
                'user_id' => $user->uuid,
                'location_name' => Location::where('name', $location)->first()->name
            ]);
        }

        // Removing previous locations
        if ($locationsToRemove->isNotEmpty()) {
            UserLocation::where('user_id', $user->uuid)
                ->whereIn('location_name', $locationsToRemove)
                ->delete();
        }

        $userData = [
            "name" => $attributes["name"] ?? $user->name,
            "email" => $attributes["email"] ?? $user->email,
            "address" => $attributes["address"] ?? $user->address,
        ];

        // Checking if file has been uploaded
        if ($req->hasFile("profilePicture")) {
            $userData["image"] = $attributes["profilePicture"]->store("users");
            !empty($user->image) && Storage::delete($user->image);
        }

        // Updating user data
        $user->update($userData);

        return redirect("/dashboard/employees")
            ->with("success", "Employee Data Updated Successfully");
    }

    public function destroy(User $user)
    {
        $this->authorize("delete", $user);
        Inventory::where("added_by", $user->uuid)->update(["added_by"=>auth()->user()->uuid]);
        Event::where("organized_by", $user->uuid)->update(["organized_by"=>auth()->user()->uuid]);
        UserLocation::where("user_id", $user->uuid)->delete();
        $user->delete();
        return redirect("/dashboard/employees")->with("success","Employee removed Successfully.");
    }
}
