<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\Inventory;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    /**
     * Show all housekeepers for management
     */
    public function housekeepersIndex()
    {
        $housekeepers = User::where('role', 'housekeeper')->latest()->paginate(15);
        return view('supervisor.housekeepers.index', compact('housekeepers'));
    }

    /**
     * Show housekeeper details
     */
    public function housekeepersShow(User $user)
    {
        if ($user->role !== 'housekeeper') {
            return redirect('/supervisor/housekeepers')->with('error', 'User is not a housekeeper');
        }
        $user->load('tasks');
        return view('supervisor.housekeepers.show', compact('user'));
    }

    /**
     * Show housekeeper performance metrics
     */
    public function performanceIndex()
    {
        $housekeepers = User::where('role', 'housekeeper')->with('tasks')->get();
        
        $performanceData = $housekeepers->map(function($housekeeper) {
            $tasks = $housekeeper->tasks;
            $completedTasks = $tasks->where('status', 'completed')->count();
            $totalTasks = $tasks->count();
            $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;
            
            return [
                'id' => $housekeeper->id,
                'name' => $housekeeper->name,
                'email' => $housekeeper->email,
                'phone' => $housekeeper->phone,
                'totalTasks' => $totalTasks,
                'completedTasks' => $completedTasks,
                'pendingTasks' => $tasks->where('status', 'pending')->count(),
                'completionRate' => $completionRate,
            ];
        });
        
        return view('supervisor.performance.index', compact('performanceData'));
    }

    /**
     * Show tasks pending approval
     */
    public function tasksApprovalIndex()
    {
        $tasks = Task::where('status', 'completed')->with('user')->latest()->paginate(15);
        return view('supervisor.tasks.approval', compact('tasks'));
    }

    /**
     * Approve a task
     */
    public function tasksApprove(Task $task)
    {
        if ($task->status !== 'completed') {
            return back()->with('error', 'Only completed tasks can be approved');
        }
        
        $task->update(['status' => 'approved']);
        return back()->with('success', 'Task approved successfully');
    }

    /**
     * Reject a task
     */
    public function tasksReject(Task $task)
    {
        if ($task->status !== 'completed') {
            return back()->with('error', 'Only completed tasks can be rejected');
        }
        
        $task->update(['status' => 'pending']);
        return back()->with('success', 'Task rejected and returned to pending');
    }

    /**
     * Show task creation form
     */
    public function tasksCreateForm()
    {
        $housekeepers = User::where('role', 'housekeeper')->get();
        return view('supervisor.tasks.create', compact('housekeepers'));
    }

    /**
     * Store a new task
     */
    public function tasksStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date|after:today',
            'location' => 'nullable|string|max:255',
        ]);

        Task::create($validated + ['status' => 'pending']);
        
        return redirect('/supervisor/tasks/create')->with('success', 'Task created successfully');
    }

    /**
     * Show all tasks assigned by this supervisor
     */
    public function tasksIndex()
    {
        $tasks = Task::with('user')->latest()->paginate(15);
        return view('supervisor.tasks.index', compact('tasks'));
    }

    /**
     * Show inventory for supervisor oversight
     */
    public function inventoryIndex()
    {
        $inventory = Inventory::latest()->paginate(15);
        return view('supervisor.inventory.index', compact('inventory'));
    }

    /**
     * Show inventory details
     */
    public function inventoryShow(Inventory $inventory)
    {
        return view('supervisor.inventory.show', compact('inventory'));
    }

    /**
     * Show reports
     */
    public function reportsIndex()
    {
        $totalHousekeepers = User::where('role', 'housekeeper')->count();
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'approved')->count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $inventoryItems = Inventory::count();
        $lowStockItems = Inventory::where('quantity', '<=', 5)->count();
        
        $tasksByStatus = Task::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();
            
        $housekeeperProductivity = User::where('role', 'housekeeper')
            ->with('tasks')
            ->get()
            ->map(function($user) {
                $completed = $user->tasks->where('status', 'approved')->count();
                $total = $user->tasks->count();
                return [
                    'name' => $user->name,
                    'completed' => $completed,
                    'total' => $total,
                    'rate' => $total > 0 ? round(($completed / $total) * 100, 2) : 0,
                ];
            });

        return view('supervisor.reports.index', compact(
            'totalHousekeepers',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'inventoryItems',
            'lowStockItems',
            'tasksByStatus',
            'housekeeperProductivity'
        ));
    }
}
