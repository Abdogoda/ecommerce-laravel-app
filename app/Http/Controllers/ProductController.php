<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::where('is_active', true);

        // Search by name or description
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category_ids')) {
            $categoryIds = is_array($request->input('category_ids')) 
                ? $request->input('category_ids') 
                : [$request->input('category_ids')];
            $query->whereIn('category_id', $categoryIds);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        // Filter featured products
        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        // Sort by
        $sortBy = $request->input('sort_by', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->withCount('orderItems')
                      ->orderByDesc('order_items_count');
                break;
            case 'latest':
            default:
                $query->latest();
        }

        $items_per_page = app(\App\Settings\GeneralSettings::class)->items_per_page ?? 12;
        
        $products = $query->paginate($items_per_page);
        $categories = Category::where('is_active', true)->get();

        return view('pages.user.products', compact('products', 'categories'));
    }

    public function show(Product $product): View
    {
        // Ensure product is active
        if (!$product->is_active) {
            abort(404);
        }

        // Get related products (same category, excluding current product)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('pages.user.product', compact('product', 'relatedProducts'));
    }
}