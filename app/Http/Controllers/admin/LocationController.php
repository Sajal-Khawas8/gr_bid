<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    public function index()
    {
        $this->authorize("viewAny", Location::class);
        $locations = Location::filter()->lazy();
        return view("pages.admin.locations", compact("locations"));
    }

    public function create()
    {
        $this->authorize("create", Location::class);
        return view("pages.admin.add-location");
    }

    public function store(Request $req)
    {
        $this->authorize("create", Location::class);
        $attributes = $req->validate([
            "location" => ["bail", "required", "min:3", "max:50", "regex:/^[a-zA-Z\s]*$/", "unique:locations,name"]
        ]);
        $location = new Location();
        $location->name = $attributes["location"];
        $location->save();
        return redirect("/dashboard/locations")->with("success", $attributes['location'] . " location has been added.");
    }

    public function edit(Location $location)
    {
        $this->authorize("update", $location);
        return view("pages.admin.edit-location", compact("location"));
    }

    public function update(Request $req, Location $location)
    {
        $this->authorize("update", $location);
        $attributes = $req->validate([
            "location" => ["bail", "min:3", "max:50", "regex:/^[a-zA-Z\s]*$/", Rule::unique(Location::class, "name")->ignore($location)],
        ]);
        $location->name = $attributes["location"];
        $location->save();
        return redirect("/dashboard/locations")->with("success", "Location Updated Successfully");
    }

    public function destroy(Location $location)
    {
        $this->authorize("delete", $location);
        $location->loadCount(["users", "items"]);
        if ($location->users_count || $location->items_count) {
            return back()->with("error","There are some Managers, Employees or products at this location. So this location can't be removed at the moment.");
        }
        $location->delete();
        return redirect("/dashboard/locations")->with("success", "Location Removed Successfully");
    }
}
