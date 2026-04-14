<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\Admin\Products\StoreProductRequest;
use App\Http\Requests\Admin\Products\UpdateProductRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Requests\ImageRequest;

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


    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $product = Product::create($validated);
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $product->addMedia($image)->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load('category', 'media');

        $similarProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('pages.admin.products.show', compact('product', 'similarProducts', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        $product->update($validated);

        return redirect()->route('admin.products.show', $product)->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function storeImage(ImageRequest $request, Product $product)
    {
        if($product->getMedia('gallery')->count() >= 8) {
            return redirect()->back()->with('error', 'Maximum 8 images allowed.');
        }
        
        $media = $product->addMedia($request->file('image'))->toMediaCollection('gallery');

        if($request->has('set_as_primary')) {
            $product->moveMediaToTop($media);
        }

        return redirect()->back()->with('success', 'Image uploaded successfully.');
    }

    public function updateImage(Request $request, Product $product, Media $media)
    {
        $product->moveMediaToTop($media);

        return redirect()->route('admin.products.show', $product)->with('success', 'Primary image updated successfully.');
    }

    public function destroyImage(Product $product, Media $media)
    {
        if($product->media->count() <= 1) {
            return redirect()->back()->with('error', 'At least one image is required.');
        }

        $media->delete();
        
        return redirect()->route('admin.products.show', $product)->with('success', 'Image deleted successfully.');
    }
}