<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function __invoke()
    {
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->latest()
            ->limit(6)
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with('media')
            ->latest()
            ->limit(8)
            ->get();

        $newProducts = Product::where('is_active', true)
            ->with('media')
            ->latest()
            ->limit(8)
            ->get();

        return view('pages.user.home', compact('categories', 'featuredProducts', 'newProducts'));
    }
}