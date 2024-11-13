<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where("user_id", auth()->id())->get();
        return view("dashboard-admin-items", compact("categories"));
    }

    public function store(Request $request)
    {
        $request->validated();

        Category::create([
            "user_id" => auth()->id(),
            "name" => $request->name,
            "slug" => Str::slug($request->name)
        ]);

        return redirect()
            ->back()
            ->with('success', 'Category has been created!');
    }

    public function update(Request $request, Category $category)
    {

        $request->validated();

        $category->update([
            "name" => $request->name,
            "slug" => Str::slug($request->name)
        ]);

        return redirect()
            ->back()
            ->with('success', 'Category has been updated!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->back()
            ->with('success', 'Category has been deleted!');
    }
}
