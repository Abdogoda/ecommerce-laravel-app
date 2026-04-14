<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\Admin\Products\StoreProductRequest;
use App\Http\Requests\Admin\Products\UpdateProductRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();
        
        $stats = [
            'total' => Product::count(),
            'in_stock' => Product::where('stock', '>', 0)->count(),
            'low_stock' => Product::where('stock', '<=', 5)->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
        ];

        $categories = Category::orderBy('name')->get();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        if ($categoryId = $request->input('category_id')) {
            $query->whereHas('category', function ($q) use ($categoryId) {
                $q->where('id', $categoryId);
            });
        }

        if ($minPrice = $request->input('min_price')) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice = $request->input('max_price')) {
            $query->where('price', '<=', $maxPrice);
        }

        if ($status = $request->input('status')) {
            if ($status === 'in_stock') {
                $query->where('stock', '>', 0);
            } elseif ($status === 'low_stock') {
                $query->where('stock', '<=', 5)->where('stock', '>', 0);
            } elseif ($status === 'out_of_stock') {
                $query->where('stock', 0);
            }
        }

        $products = $query->paginate(20)->withQueryString();
        return view('pages.admin.products.index', compact('products', 'categories', 'stats'));
    }

    public function create()
    {
        //
    }

    public function store(StoreProductRequest $request)
    {
        dd($request->validated());
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }
}