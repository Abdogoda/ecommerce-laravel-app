<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\Admin\Products\StoreProductRequest;
use App\Http\Requests\Admin\Products\UpdateProductRequest;
use App\Models\Category;
use App\Exports\ProductExport;
use App\Services\ExportService;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Requests\ImageRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'tags')->latest();
        $orderSettings = app(\App\Settings\OrderSettings::class);
        
        $stats = [
            'total' => Product::count(),
            'in_stock' => Product::where('stock', '>', 0)->count(),
            'low_stock' => Product::where('stock', '<=', $orderSettings->low_stock_threshold)->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
        ];

        $categories = Category::orderBy('name')->get();
        $locales = config('app.locales', [config('app.locale')]);

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
                $query->where('stock', '<=', $orderSettings->low_stock_threshold)->where('stock', '>', 0);
            } elseif ($status === 'out_of_stock') {
                $query->where('stock', 0);
            }
        }

        $items_per_page = app(\App\Settings\GeneralSettings::class)->items_per_page ?? 12;

        $products = $query->paginate($items_per_page)->withQueryString();
        return view('pages.admin.products.index', compact('products', 'categories', 'stats', 'locales'));
    }


    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        
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
        // Generate slug only from English name
        if (!empty($names)) {
            $validated['name'] = $names[$currentLocale] ?? reset($names);
            $validated['description'] = $descriptions[$currentLocale] ?? reset($descriptions) ?? '';
        }

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $product->addMedia($image)->toMediaCollection('gallery');
            }
        }

        // Check if tags were submitted (even if empty array, which means delete all tags)
        if ($request->has('_tags_submitted') || $request->has('tags')) {
            $tags = $request->input('tags', []);
            $product->syncTags($tags);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load('category', 'media', 'tags');

        $similarProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $categories = Category::orderBy('name')->get();
        $locales = config('app.locales', [config('app.locale')]);

        return view('pages.admin.products.show', compact('product', 'similarProducts', 'categories', 'locales'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

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
        // Generate slug only from English name
        if (!empty($names)) {
            $validated['name'] = $names[$currentLocale] ?? reset($names);
            $validated['description'] = $descriptions[$currentLocale] ?? reset($descriptions) ?? '';
        }

        $product->update($validated);

        // Check if tags were submitted (even if empty array, which means delete all tags)
        if ($request->has('_tags_submitted') || $request->has('tags')) {
            $tags = $request->input('tags', []);
            $product->syncTags($tags);
        }

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

    public function exportFiltered(Request $request)
    {
        $query = Product::with('category', 'tags');
        $orderSettings = app(\App\Settings\OrderSettings::class);

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
                $query->where('stock', '<=', $orderSettings->low_stock_threshold)->where('stock', '>', 0);
            } elseif ($status === 'out_of_stock') {
                $query->where('stock', 0);
            }
        }

        return ExportService::exportFiltered($query, ProductExport::class);
    }

    public function exportAll()
    {
        return ExportService::exportAll(Product::class, ProductExport::class);
    }
}