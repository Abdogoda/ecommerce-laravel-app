<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Message;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $stats = [
            'users' => User::where('is_active', true)->count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'products' => Product::where('is_active', true)->count(),
            'categories' => Category::where('is_active', true)->count(),
            'orders' => Order::where('status', '!=', 'cancelled')->count(),
            'revenue' => Order::where('status', 'delivered')->sum('total'),
            'messages' => Message::count(),
            'unread_messages' => Message::where('is_read', false)->count(),
        ];

        // Get monthly orders and revenue data for the last 12 months
        $monthlyData = $this->getMonthlyOrdersData();

        // Get category distribution
        $categoryData = $this->getCategoryDistribution();

        // Get top products by quantity ordered
        $topProducts = $this->getTopProducts();

        // Get top customers by total orders
        $topCustomers = $this->getTopCustomers();

        return view('pages.admin.dashboard', compact('stats', 'monthlyData', 'categoryData', 'topProducts', 'topCustomers'));
    }

    /**
     * Get monthly orders and revenue data for the last 12 months
     */
    private function getMonthlyOrdersData()
    {
        $monthsData = [];
        $ordersData = [];
        $revenueData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthsData[] = $date->format('M');

            // Count orders for this month
            $orders = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', '!=', 'cancelled')
                ->count();
            $ordersData[] = $orders;

            // Sum revenue for this month
            $revenue = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'completed')
                ->sum('total');
            $revenueData[] = (float)$revenue;
        }

        return [
            'labels' => $monthsData,
            'orders' => $ordersData,
            'revenue' => $revenueData,
        ];
    }

    /**
     * Get category distribution
     */
    private function getCategoryDistribution()
    {
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderByDesc('products_count')
            ->take(6)
            ->get();

        $labels = $categories->pluck('name')->toArray();
        $data = $categories->pluck('products_count')->toArray();
        $colors = ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899'];

        return [
            'labels' => $labels,
            'data' => $data,
            'colors' => array_slice($colors, 0, count($labels)),
        ];
    }

    /**
     * Get top 5 products by quantity ordered
     */
    private function getTopProducts()
    {
        $products = Product::select('products.id', 'products.name')
            ->selectRaw('SUM(order_items.quantity) as total_quantity')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        return [
            'labels' => $products->pluck('name')->toArray(),
            'data' => $products->pluck('total_quantity')->toArray(),
        ];
    }

    /**
     * Get top 5 customers by total orders
     */
    private function getTopCustomers()
    {
        $users = User::select('users.id', 'users.name')
            ->selectRaw('COUNT(orders.id) as total_orders')
            ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_orders')
            ->take(5)
            ->get();

        return [
            'labels' => $users->pluck('name')->toArray(),
            'data' => $users->pluck('total_orders')->toArray(),
        ];
    }
}