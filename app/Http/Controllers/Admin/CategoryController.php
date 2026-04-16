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
        $categories = Category::with('tags')->withCount('products')->latest()->paginate(20);
        $locales = config('app.locales', [config('app.locale')]);
        return view('pages.admin.categories.index', compact('categories', 'locales'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('icon_file')) {
            $iconPath = $request->file('icon_file')->store('categories', 'public');
            $validated['icon'] = $iconPath;
        }

        // Handle translations
        $locales = config('app.locales', [config('app.locale')]);
        $currentLocale = app()->getLocale();
        $names = [];
        $descriptions = [];
        
        foreach ($locales as $locale) {
            $name = trim($request->input("name_{$locale}", ''));
            $description = trim($request->input("description_{$locale}", ''));
            
            if ($name) {
                $names[$locale] = $name;
                $descriptions[$locale] = $description ?: null;
            }
        }

        // Set the current locale's name as the primary name for creation
        if (!empty($names)) {
            $validated['name'] = $names[$currentLocale] ?? reset($names);
            $validated['description'] = $descriptions[$currentLocale] ?? reset($descriptions) ?? '';
        }

        $category = Category::create($validated);

        // Check if tags were submitted (even if empty array, which means delete all tags)
        if ($request->has('_tags_submitted') || $request->has('tags')) {
            $tags = $request->input('tags', []);
            $category->syncTags($tags);
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function show(Category $category)
    {
        $category->load('products', 'tags');
        $locales = config('app.locales', [config('app.locale')]);
        return view('pages.admin.categories.show', compact('category', 'locales'));
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

        // Handle translations
        $locales = config('app.locales', [config('app.locale')]);
        $currentLocale = app()->getLocale();
        $names = [];
        $descriptions = [];
        
        foreach ($locales as $locale) {
            $name = trim($request->input("name_{$locale}", ''));
            $description = trim($request->input("description_{$locale}", ''));
            
            if ($name) {
                $names[$locale] = $name;
                $descriptions[$locale] = $description ?: null;
            }
        }

        // Set the current locale's name as the primary name for updates
        if (!empty($names)) {
            $validated['name'] = $names[$currentLocale] ?? reset($names);
            $validated['description'] = $descriptions[$currentLocale] ?? reset($descriptions) ?? '';
        }

        $category->update($validated);

        // Check if tags were submitted (even if empty array, which means delete all tags)
        if ($request->has('_tags_submitted') || $request->has('tags')) {
            $tags = $request->input('tags', []);
            $category->syncTags($tags);
        }

        return redirect()
            ->route('admin.categories.show', $category->slug)
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