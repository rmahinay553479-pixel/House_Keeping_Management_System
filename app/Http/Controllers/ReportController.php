<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->get('from', now()->startOfMonth()->toDateString());
        $dateTo = $request->get('to', now()->toDateString());

        // Task Statistics
        $taskStats = [
            'total' => Task::whereBetween('scheduled_date', [$dateFrom, $dateTo])->count(),
            'completed' => Task::whereBetween('scheduled_date', [$dateFrom, $dateTo])
                ->where('status', 'completed')->count(),
            'pending' => Task::whereBetween('scheduled_date', [$dateFrom, $dateTo])
                ->where('status', 'pending')->count(),
            'in_progress' => Task::whereBetween('scheduled_date', [$dateFrom, $dateTo])
                ->where('status', 'in_progress')->count(),
        ];

        $taskStats['completion_rate'] = $taskStats['total'] > 0 
            ? round(($taskStats['completed'] / $taskStats['total']) * 100, 1) 
            : 0;

        // Tasks by Priority
        $tasksByPriority = Task::whereBetween('scheduled_date', [$dateFrom, $dateTo])
            ->select('priority', DB::raw('count(*) as count'))
            ->groupBy('priority')
            ->pluck('count', 'priority');

        // Staff Performance
        $staffPerformance = User::where('role', 'cleaner')
            ->withCount(['tasks as completed_tasks' => function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('scheduled_date', [$dateFrom, $dateTo])
                    ->where('status', 'completed');
            }])
            ->withCount(['tasks as total_tasks' => function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('scheduled_date', [$dateFrom, $dateTo]);
            }])
            ->having('total_tasks', '>', 0)
            ->orderByDesc('completed_tasks')
            ->get();

        // Inventory Alerts
        $lowStockItems = Inventory::where('status', '!=', 'in_stock')
            ->orderBy('quantity')
            ->get();

        $inventoryStats = [
            'total_items' => Inventory::count(),
            'low_stock' => Inventory::where('status', 'low_stock')->count(),
            'out_of_stock' => Inventory::where('status', 'out_of_stock')->count(),
            'total_value' => Inventory::sum(DB::raw('quantity * cost_per_unit')),
        ];

        // Daily Task Trends (last 30 days)
        $taskTrends = Task::where('scheduled_date', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(scheduled_date) as date'),
                DB::raw('count(*) as total'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.reports.index', compact(
            'taskStats',
            'tasksByPriority',
            'staffPerformance',
            'lowStockItems',
            'inventoryStats',
            'taskTrends',
            'dateFrom',
            'dateTo'
        ));
    }

    public function export(Request $request)
    {
        $dateFrom = $request->get('from', now()->startOfMonth()->toDateString());
        $dateTo = $request->get('to', now()->toDateString());
        $format = $request->get('format', 'pdf'); // 'pdf' or 'csv'

        // Task Statistics
        $taskStats = [
            'total' => Task::whereBetween('scheduled_date', [$dateFrom, $dateTo])->count(),
            'completed' => Task::whereBetween('scheduled_date', [$dateFrom, $dateTo])
                ->where('status', 'completed')->count(),
            'pending' => Task::whereBetween('scheduled_date', [$dateFrom, $dateTo])
                ->where('status', 'pending')->count(),
            'in_progress' => Task::whereBetween('scheduled_date', [$dateFrom, $dateTo])
                ->where('status', 'in_progress')->count(),
        ];

        $taskStats['completion_rate'] = $taskStats['total'] > 0 
            ? round(($taskStats['completed'] / $taskStats['total']) * 100, 1) 
            : 0;

        // Tasks by Priority
        $tasksByPriority = Task::whereBetween('scheduled_date', [$dateFrom, $dateTo])
            ->select('priority', DB::raw('count(*) as count'))
            ->groupBy('priority')
            ->pluck('count', 'priority');

        // Inventory Alerts
        $lowStockItems = Inventory::where('status', '!=', 'in_stock')
            ->orderBy('quantity')
            ->get();

        $inventoryStats = [
            'total_items' => Inventory::count(),
            'low_stock' => Inventory::where('status', 'low_stock')->count(),
            'out_of_stock' => Inventory::where('status', 'out_of_stock')->count(),
            'total_value' => Inventory::sum(DB::raw('quantity * cost_per_unit')),
        ];

        if ($format === 'pdf') {
            // Generate PDF
            $pdf = PDF::loadView('admin.reports.pdf', compact(
                'taskStats',
                'tasksByPriority',
                'lowStockItems',
                'inventoryStats',
                'dateFrom',
                'dateTo'
            ));

            $filename = 'house-keeping-report-' . now()->format('Y-m-d-His') . '.pdf';
            return $pdf->download($filename);
        } else {
            // Generate CSV
            $csv = "House Keeping Management System - Report\n";
            $csv .= "Generated: " . now()->format('Y-m-d H:i:s') . "\n";
            $csv .= "Period: $dateFrom to $dateTo\n\n";
            
            $csv .= "TASK STATISTICS\n";
            $csv .= "Total Tasks,Completed,In Progress,Pending,Completion Rate\n";
            $csv .= "{$taskStats['total']},{$taskStats['completed']},{$taskStats['in_progress']},{$taskStats['pending']},{$taskStats['completion_rate']}%\n\n";

            $csv .= "INVENTORY STATISTICS\n";
            $csv .= "Total Items,Low Stock,Out of Stock,Total Value\n";
            $csv .= "{$inventoryStats['total_items']},{$inventoryStats['low_stock']},{$inventoryStats['out_of_stock']},₱" . number_format($inventoryStats['total_value'] ?? 0, 2) . "\n\n";

            $csv .= "LOW STOCK ITEMS\n";
            $csv .= "Item Name,Category,Current Qty,Unit,Min Level,Status\n";
            foreach ($lowStockItems as $item) {
                $csv .= "\"{$item->name}\",\"{$item->category}\",{$item->quantity},{$item->unit},{$item->min_stock_level},\"{$item->status}\"\n";
            }

            $filename = 'house-keeping-report-' . now()->format('Y-m-d-His') . '.csv';
            return response($csv)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', "attachment; filename=\"$filename\"");
        }
    }
}
