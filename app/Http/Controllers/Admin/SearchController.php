<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\PermissionEnum;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validate and sanitize query
        $query = trim($request->input('q', ''));
        $query = substr($query, 0, 100); // Limit to 100 characters
        $limit = 5; // Results per category
        
        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $user = Auth::user();

        $results = [
            'products' => [],
            'categories' => [],
            'orders' => [],
            'users' => [],
        ];

        // Search Products
        if ($user->can(PermissionEnum::VIEW_PRODUCTS->value)) {
            $results['products'] = Product::where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->limit($limit)
                ->get(['id', 'name', 'price', 'stock', 'slug'])
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'type' => 'product',
                        'icon' => 'fa-box',
                        'badge' => '$' . number_format($product->price, 2),
                        'url' => route('admin.products.show', $product->slug),
                        'subtitle' => 'Stock: ' . $product->stock,
                    ];
                })->values();
        }

        // Search Categories
        if ($user->can(PermissionEnum::VIEW_CATEGORIES->value)) {
            $results['categories'] = Category::where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->limit($limit)
                ->get(['id', 'name', 'slug'])
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'type' => 'category',
                        'icon' => 'fa-layer-group',
                        'badge' => 'Category',
                        'url' => route('admin.categories.show', $category->slug),
                        'subtitle' => null,
                    ];
                })->values();
        }

        // Search Orders
        if ($user->can(PermissionEnum::VIEW_ORDERS->value)) {
            $results['orders'] = Order::where('order_number', 'like', "%{$query}%")
                ->orWhereHas('user', function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%");
                })
                ->limit($limit)
                ->get(['id', 'order_number', 'total', 'status'])
                ->map(function ($order) {
                    return [
                        'id' => $order->id,
                        'name' => 'Order #' . $order->order_number,
                        'type' => 'order',
                        'icon' => 'fa-shopping-cart',
                        'badge' => '$' . number_format($order->total, 2),
                        'url' => route('admin.orders.show', $order->order_number),
                        'subtitle' => ucfirst($order->status),
                    ];
                })->values();
        }

        // Search Users
        if ($user->can(PermissionEnum::VIEW_USERS->value)) {
            $results['users'] = User::where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->limit($limit)
                ->get(['id', 'name', 'email', 'is_active'])
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'type' => 'user',
                        'icon' => 'fa-user',
                        'badge' => $user->is_active ? 'Active' : 'Inactive',
                        'url' => route('admin.users.show', $user->id),
                        'subtitle' => $user->email,
                    ];
                })->values();
        }

        // Filter out empty categories and flatten results
        $results = array_filter($results, fn($items) => !empty($items));

        return response()->json([
            'results' => $results,
            'query' => $query,
            'total' => array_reduce($results, fn($carry, $items) => $carry + count($items), 0),
        ]);
    }
}