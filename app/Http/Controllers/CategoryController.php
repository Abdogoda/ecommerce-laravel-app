<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        // get all active categories with active products count
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function ($query) {
                $query->where('is_active', true);
            }])
            ->latest()
            ->get();
            
        return view('pages.user.categories', compact('categories'));
    }

    public function show(Category $category): View
    {
        if (!$category->is_active) {
            abort(404);
        }

        $category->load(['products' => function ($query) {
            $query->where('is_active', true)->latest();
        }]);

        return view('pages.user.category', compact('category'));
    }
}