<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view("dashboard-admin-items", compact("categories"));
    }

    public function store(StoreCategoryRequest $request)
    {
        $request->validated();

        Category::create([
            "user_id" => auth()->id(),
            "name" => $request->name,
            "slug" => Str::slug($request->name)
        ]);

        return redirect()->route("dashboard-admin-items")->with("success", "Category has been created!");
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $request->validated();

        $category = Category::findOrFail($id);
        $category->update([
            "name" => $request->name,
            "slug" => Str::slug($request->name)
        ]);

        return redirect()->route("dashboard-admin-items")->with("success", "Category has been updated!");
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()
            ->route("dashboard-admin-items")
            ->with('success', 'Category has been deleted!');
    }
}
