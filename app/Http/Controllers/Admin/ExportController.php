<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\UserExport;
use App\Exports\ProductExport;
use App\Exports\CategoryExport;
use App\Exports\ActivityExport;
use App\Exports\OrderExport;
use App\Exports\NotificationExport;
use App\Exports\RoleExport;
use App\Services\ExportService;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Spatie\Activitylog\Models\Activity;
use App\Models\Order;
use Illuminate\Notifications\DatabaseNotification;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Exception;

class ExportController extends Controller
{
    public function exportFiltered(Request $request)
    {
        try {
            $table = $request->input('table');
            $data = $request->input('data', []); // Table data from frontend
            $filters = $request->input('filters', []);

            // Parse JSON strings if they come as form data
            if (is_string($data)) {
                $data = json_decode($data, true) ?? [];
            }
            if (is_string($filters)) {
                $filters = json_decode($filters, true) ?? [];
            }

            // Map table names to models and export classes
            $tableConfig = [
                'users' => ['model' => User::class, 'export' => UserExport::class],
                'products' => ['model' => Product::class, 'export' => ProductExport::class],
                'categories' => ['model' => Category::class, 'export' => CategoryExport::class],
                'activities' => ['model' => Activity::class, 'export' => ActivityExport::class],
                'orders' => ['model' => Order::class, 'export' => OrderExport::class],
                'notifications' => ['model' => DatabaseNotification::class, 'export' => NotificationExport::class],
                'roles' => ['model' => Role::class, 'export' => RoleExport::class],
            ];

            if (!isset($tableConfig[$table])) {
                return response()->json(['error' => "Export for table '{$table}' not found"], 404);
            }

            $config = $tableConfig[$table];
            $exportClass = $config['export'];

            // If we have actual data from frontend, use it directly
            if (!empty($data) && is_array($data) && count($data) > 1) {
                // First row is headers, rest is data
                $headers = array_shift($data);
                $collection = collect($data);
                
                $export = new $exportClass();
                $export->setDirectData($collection);
                
                return Excel::download($export, $export->generateFilename(), \Maatwebsite\Excel\Excel::XLSX);
            }

            // Otherwise, rebuild query based on filters
            $modelClass = $config['model'];
            $query = $modelClass::query();

            $this->applyFilters($query, $table, $filters);

            if (!empty($filters['per_page'])) {
                $query->limit($filters['per_page']);
            } else {
                $query->limit(100);
            }

            return ExportService::exportFiltered($query, $exportClass);
        } catch (Exception $e) {
            Log::error('Export Error: ' . $e->getMessage(), ['table' => $table ?? 'unknown', 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Export failed: ' . $e->getMessage()], 500);
        }
    }

    public function exportAll(Request $request)
    {
        try {
            $table = $request->input('table');

            // Map table names to models and export classes
            $tableConfig = [
                'users' => ['model' => User::class, 'export' => UserExport::class],
                'products' => ['model' => Product::class, 'export' => ProductExport::class],
                'categories' => ['model' => Category::class, 'export' => CategoryExport::class],
                'activities' => ['model' => Activity::class, 'export' => ActivityExport::class],
                'orders' => ['model' => Order::class, 'export' => OrderExport::class],
                'notifications' => ['model' => DatabaseNotification::class, 'export' => NotificationExport::class],
                'roles' => ['model' => Role::class, 'export' => RoleExport::class],
            ];

            if (!isset($tableConfig[$table])) {
                return response()->json(['error' => "Export for table '{$table}' not found"], 404);
            }

            $config = $tableConfig[$table];
            $modelClass = $config['model'];
            $exportClass = $config['export'];

            return ExportService::exportAll($modelClass, $exportClass);
        } catch (Exception $e) {
            Log::error('Export Error: ' . $e->getMessage(), ['table' => $table ?? 'unknown', 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Export failed: ' . $e->getMessage()], 500);
        }
    }

    private function applyFilters($query, $table, $filters)
    {
        switch ($table) {
            case 'users':
                if (!empty($filters['search'])) {
                    $query->where('name', 'like', "%{$filters['search']}%")
                          ->orWhere('email', 'like', "%{$filters['search']}%");
                }
                if (!empty($filters['status'])) {
                    $query->where('is_active', $filters['status'] === 'active' ? 1 : 0);
                }
                if (!empty($filters['role_id'])) {
                    $query->whereHas('roles', fn($q) => $q->where('id', $filters['role_id']));
                }
                break;

            case 'products':
                if (!empty($filters['search'])) {
                    $query->where('name', 'like', "%{$filters['search']}%");
                }
                if (!empty($filters['category_id'])) {
                    $query->where('category_id', $filters['category_id']);
                }
                if (!empty($filters['min_price'])) {
                    $query->where('price', '>=', $filters['min_price']);
                }
                if (!empty($filters['max_price'])) {
                    $query->where('price', '<=', $filters['max_price']);
                }
                if (!empty($filters['status'])) {
                    $query->where('is_active', $filters['status'] === 'active' ? 1 : 0);
                }
                break;

            case 'categories':
                if (!empty($filters['search'])) {
                    $query->where('name', 'like', "%{$filters['search']}%");
                }
                if (!empty($filters['status'])) {
                    $query->where('is_active', $filters['status'] === 'active' ? 1 : 0);
                }
                break;

            case 'activities':
                if (!empty($filters['search'])) {
                    $query->where('description', 'like', "%{$filters['search']}%");
                }
                if (!empty($filters['user_id'])) {
                    $query->where('causer_id', $filters['user_id']);
                }
                if (!empty($filters['from'])) {
                    $query->where('created_at', '>=', $filters['from'] . ' 00:00:00');
                }
                if (!empty($filters['to'])) {
                    $query->where('created_at', '<=', $filters['to'] . ' 23:59:59');
                }
                break;

            case 'orders':
                if (!empty($filters['status'])) {
                    $query->where('status', $filters['status']);
                }
                if (!empty($filters['search'])) {
                    $query->where('order_number', 'like', "%{$filters['search']}%")
                          ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$filters['search']}%"));
                }
                break;

            case 'notifications':
                if (!empty($filters['read'])) {
                    if ($filters['read'] === 'unread') {
                        $query->whereNull('read_at');
                    } elseif ($filters['read'] === 'read') {
                        $query->whereNotNull('read_at');
                    }
                }
                break;

            case 'roles':
                if (!empty($filters['search'])) {
                    $query->where('name', 'like', "%{$filters['search']}%");
                }
                break;
        }
    }
}