<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Admin\Categories\StoreCategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateCategoryRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->latest()->paginate(20);
        return view('pages.admin.categories.index', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('icon_file')) {
            $iconPath = $request->file('icon_file')->store('categories', 'public');
            $validated['icon'] = $iconPath;
        }

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function show(Category $category)
    {
        $category->load('products');
        return view('pages.admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        //
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        if ($request->hasFile('icon_file')) {
            if ($category->icon && Str::startsWith($category->icon, 'categories/')) {
                Storage::disk('public')->delete($category->icon);
            }
            
            $iconPath = $request->file('icon_file')->store('categories', 'public');
            $validated['icon'] = $iconPath;
        }

        $category->update($validated);

        return redirect()
            ->route('admin.categories.show', $category)
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->icon && Str::startsWith($category->icon, 'categories/')) {
            Storage::disk('public')->delete($category->icon);
        }
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}