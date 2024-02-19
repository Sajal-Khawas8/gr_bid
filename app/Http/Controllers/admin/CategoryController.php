<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $this->authorize("viewAny", Category::class);
        $categories = Category::with("items")->filter()->lazy();
        return view("pages.admin.categories", compact("categories"));
    }

    public function create()
    {
        $this->authorize("create", Category::class);
        return view("pages.admin.add-category");
    }

    public function store(Request $req)
    {
        $this->authorize("create", Category::class);
        $attributes = $req->validate([
            "category" => ["bail", "required", "min:3", "max:50", "regex:/^[a-zA-Z\s]*$/", "unique:categories,name"]
        ]);
        $category = new Category();
        $category->name = $attributes["category"];
        $category->save();
        return redirect("/dashboard/categories")->with("success", $attributes['category'] . " category has been added.");
    }

    public function edit(Category $category)
    {
        $this->authorize("update", $category);
        return view("pages.admin.edit-category", compact("category"));
    }

    public function update(Request $req, Category $category)
    {
        $this->authorize("update", $category);
        $attributes = $req->validate([
            "category" => ["bail", "min:3", "max:50", "regex:/^[a-zA-Z\s]*$/", Rule::unique(Category::class, "name")->ignore($category)],
        ]);
        $category->name = $attributes["category"];
        $category->save();
        return redirect("/dashboard/categories")->with("success", "Category Updated Successfully");
    }

    public function destroy(Category $category)
    {
        $this->authorize("delete", $category);
        $itemsCount= $category->loadCount("items")->items_count;
        if ($itemsCount) {
            return back()->with("error","This category has $itemsCount products. So it can't be deleted at the moment.");
        }
        $category->delete();
        return redirect("/dashboard/categories")->with("success", "Category Deleted Successfully");
    }
}
