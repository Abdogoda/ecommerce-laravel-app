<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Admin\Categories\StoreCategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateCategoryRequest;
use App\Exports\CategoryExport;
use App\Services\ExportService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::with('tags')->withCount('products')->latest();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($minProducts = $request->input('min_products')) {
            $query->having('products_count', '>=', $minProducts);
        }

        if ($maxProducts = $request->input('max_products')) {
            $query->having('products_count', '<=', $maxProducts);
        }

        $items_per_page = app(\App\Settings\GeneralSettings::class)->items_per_page ?? 12;

        $categories = $query->paginate($items_per_page)->withQueryString();
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

    public function exportFiltered(Request $request)
    {
        $query = Category::with('tags');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        return ExportService::exportFiltered($query, CategoryExport::class);
    }

    public function exportAll()
    {
        return ExportService::exportAll(Category::class, CategoryExport::class);
    }
}