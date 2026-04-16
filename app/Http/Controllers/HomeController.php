<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    public function __invoke()
    {
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->latest()
            ->get(6);

        return view('pages.user.home', compact('categories'));
    }
}