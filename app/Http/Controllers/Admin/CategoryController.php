<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
   
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.categories', [
            'categories' => $categories
        ]);
    }

    
    public function create()
    {
        return view('admin.categories.create');

    }

    
    public function store(Request $request)
    {
        // validation
        $validated = $request->validate([
            'title' => 'required|max:255',
            'image' => 'required|image|max:1024'//not more than 50 kilobytes
        ]);
        
        // storing in database, take request parameter from the $validated, and not from the $request.
        $path = $request->file('image')->store('categories', 'public');

        $category = new Category();
        $category->title = $validated['title'];
        $category->image = $path;
        $category->save();

        return redirect()->route('admin.categories.index')->with('status', $validated['title'].' category created');

    }

    // public function show(Category $category)
    
    
    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category
        ]);
    }

    
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'image' => 'image|max:1024'//not more than 50 kilobytes
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            if ($category->image) {
                Storage::delete($category->image);
            }
            $category->image = $path;
        }
       

        $category->title = $validated['title'];
        $category->save();

        return redirect()->route('admin.categories.index')->with('status', $validated['title'].' category updated');

    }

    public function destroy(Category $category)
    {
        Storage::delete($category->image);
        $title = $category->title;
        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', $title.' category deleted');
    }
}
