<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\ProductImage;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class InventoryController extends Controller
{
    private function getLocations()
    {
        $userLocations = auth()->user()->load("locations")->locations;
        if ($userLocations->isEmpty()) {
            $userLocations = Location::all(['name as location_name']);
        }
        $userLocations = $userLocations->pluck('location_name');
        return $userLocations;
    }

    public function index()
    {
        $this->authorize("viewAny", Inventory::class);
        $inventory = auth()->user()->hasRole("admin") ?
            Inventory::with("images")->filter(request(["category", "condition", "location", "added_by", "search"]))->lazy() :
            Inventory::with("images")
                ->filter(request(["category", "condition", "location", "search"]))
                ->where("added_by", auth()->user()->uuid)
                ->lazy();

            $categories = Category::lazy();
            $locations = Location::lazy();
            $users = User::role(["admin", "manager", "employee"])
                ->with("roles")->get()
                ->groupBy(function ($user) {
                    return $user->roles->first()->name;
                });

        return view("pages.admin.inventory", compact("inventory","categories", "locations", "users"));
    }

    public function create()
    {
        $this->authorize("create", Inventory::class);
        $categories = Category::lazy();
        if ($categories->isEmpty()) {
            return back()->with("error", "Please add at least one Category before adding Items!");
        }
        $locations = auth()->user()->load("locations")->locations;
        if ($locations->isEmpty()) {
            $locations = Location::all(['name as location_name']);
        }
        $locations = $locations->pluck('location_name');

        return view("pages.admin.add-item", compact("categories", "locations"));
    }

    public function store(Request $req)
    {
        $this->authorize("create", Inventory::class);
        $userLocations= $this->getLocations();
        $attributes = $req->validate([
            "name" => ["bail", "required", "min:3", "max:50", "regex:/^[a-zA-Z\s]*$/"],
            "bid" => ["bail", "required", "numeric", "decimal:0,2"],
            "category" => ["bail", "required", "exists:categories,name"],
            "condition" => ["bail", "required", "in:new,old"],
            "old_months" => ["bail", "nullable", "required_if:condition,old", "integer"],
            "images" => ["required"],
            "images.*" => ["image"],
            "locations" => ["required"],
            "locations.*" => [Rule::in($userLocations)],
            "description" => ["required", "min:3"],
        ]);

        foreach ($attributes["locations"] as $location) {
            $item = Inventory::create([
                "name" => $attributes["name"],
                "description" => $attributes["description"],
                "category" => $attributes["category"],
                "condition" => $attributes["condition"],
                "old_months" => $attributes["old_months"],
                "starting_bid" => $attributes["bid"],
                "location" => $location,
                "added_by" => auth()->user()->uuid
            ]);

            foreach ($req->file('images') as $image) {
                $imageName = $image->storeAs("inventory", uniqid());
                ProductImage::create([
                    "url" => $imageName,
                    "product_id" => $item->id,
                ]);
            }
        }
        return redirect("/dashboard/inventory")->with("success", "Item Added Successfully");
    }

    public function edit(Request $req, Inventory $product)
    {
        $this->authorize("update", $product);
        $product->load("images");
        $categories = Category::lazy();
        $locations = auth()->user()->load("locations")->locations;
        if ($locations->isEmpty()) {
            $locations = Location::all(['name as location_name']);
        }
        $locations = $locations->pluck('location_name');
        // return $product;
        return view("pages.admin.edit-item", compact("product", "categories", "locations"));
    }

    public function deleteImages(Request $req, Inventory $product)
    {
        $this->authorize("update", $product);

        $validator = Validator::make($req->all(), [
            "deletedImages" => ['required'],
            "deletedImages.*" => ['exists:product_images,id'],
        ]);

        if ($validator->fails()) {
            return back()->with('error', "Something went wrong! Please try again.");
        }
        $product->load("images");
        $images = $product->images->pluck('id');
        foreach ($req->deletedImages as $imageId) {
            if ($images->doesntContain($imageId)) {
                return back()->with('error', "Something went wrong! Please try again.");
            }
            $imageUrl = ProductImage::find($imageId)->url;
            ProductImage::where("id", $imageId)->delete();
            Storage::delete($imageUrl);
        }
        return back()->with("success", "Images deleted successfully.");
    }

    public function update(Request $req, Inventory $product)
    {
        $this->authorize("update", $product);

        $userLocations= $this->getLocations();

        $attributes = $req->validate([
            "name" => ["bail", "nullable", "min:3", "max:50", "regex:/^[a-zA-Z\s]*$/"],
            "bid" => ["bail", "nullable", "numeric", "decimal:0,2"],
            "category" => ["exists:categories,name"],
            "condition" => ["in:new,old"],
            "old_months" => ["nullable", "integer"],
            "images" => [Rule::requiredIf($product->load("images")->images->isEmpty())],
            "images.*" => ["image"],
            "location" => [Rule::in($userLocations)],
            "description" => ["nullable", "min:3"],
        ]);

        if ($attributes['condition']==="new") {
            $product->old_months=null;
            $product->save();
        } elseif ($attributes['condition']==="old" && is_null($attributes["old_months"])) {
            return back()->with("error","Please enter how many months old this item is!!");
        } else {
            $product->old_months = $attributes["old_months"];
        }

        $product->update([
            "name" => $attributes["name"] ?? $product->name,
            "description" => $attributes["description"] ?? $product->description,
            "category" => $attributes["category"] ?? $product->category,
            "condition" => $attributes["condition"] ?? $product->condition,
            "starting_bid" => $attributes["bid"] ?? $product->starting_bid,
            "location" => $attributes["location"] ?? $product->location,
        ]);

        foreach ($req->file('images') ?? [] as $image) {
            $imageName = $image->storeAs("inventory", uniqid());
            ProductImage::create([
                "url" => $imageName,
                "product_id" => $product->id,
            ]);
        }

        return redirect("/dashboard/inventory")->with("success", "Product Data Updated Successfully");
    }

    public function destroy(Inventory $product)
    {
        $this->authorize("delete", $product);
        if ($product->loadCount("event")->event_count) {
            return back()->with("error", "This product has been listed in an event. So it can't be deleted.");
        }
        ProductImage::where("product_id", $product->id)->delete();
        $product->delete();
        return redirect("/dashboard/inventory")->with("success", "Product has been deleted Successfully.");
    }
}
