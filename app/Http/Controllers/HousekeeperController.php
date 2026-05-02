<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Inventory;
use Illuminate\Session\SessionManager as Session;
use Illuminate\Support\Facades\Session as SessionFacade;

class HousekeeperController extends Controller
{
    /**
     * Show the housekeeper dashboard
     */
    public function dashboard()
    {
        $sessionUser = SessionFacade::get('user');
        $user = (object)$sessionUser;
        $userId = $user->id;

        // Get task statistics
        $totalTasks = Task::where('assigned_to', $userId)->count();
        $completedTasks = Task::where('assigned_to', $userId)
            ->where('status', 'completed')
            ->count();
        $pendingTasks = Task::where('assigned_to', $userId)
            ->where('status', 'pending')
            ->count();
        $approvedTasks = Task::where('assigned_to', $userId)
            ->where('status', 'approved')
            ->count();

        return view('housekeeper.dashboard', compact(
            'user',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'approvedTasks'
        ));
    }

    /**
     * Show all tasks assigned to this housekeeper
     */
    public function tasksIndex()
    {
        $sessionUser = SessionFacade::get('user');
        $user = (object)$sessionUser;
        $tasks = Task::where('assigned_to', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('housekeeper.tasks.index', compact('tasks', 'user'));
    }

    /**
     * Show a single task
     */
    public function tasksShow(Task $task)
    {
        $sessionUser = SessionFacade::get('user');
        $user = (object)$sessionUser;

        // Check if this task is assigned to the logged-in housekeeper
        if ($task->assigned_to !== $user->id) {
            abort(403, 'Unauthorized access');
        }

        return view('housekeeper.tasks.show', compact('task', 'user'));
    }

    /**
     * Update task status
     */
    public function tasksUpdate(Task $task)
    {
        $sessionUser = SessionFacade::get('user');
        $user = (object)$sessionUser;

        // Check if this task is assigned to the logged-in housekeeper
        if ($task->assigned_to !== $user->id) {
            abort(403, 'Unauthorized access');
        }

        $request = request();
        
        $validated = $request->validate([
            'status' => 'required|in:pending,completed'
        ]);

        $task->status = $validated['status'];
        $task->save();

        return redirect()->route('housekeeper.tasks.show', $task->id)
            ->with('success', 'Task status updated successfully!');
    }

    /**
     * Show housekeeper profile
     */
    public function profileShow()
    {
        $sessionUser = SessionFacade::get('user');
        $user = (object)$sessionUser;

        return view('housekeeper.profile.show', compact('user'));
    }

    /**
     * Show inventory items
     */
    public function inventoryIndex()
    {
        $sessionUser = SessionFacade::get('user');
        $user = (object)$sessionUser;
        $inventory = Inventory::paginate(10);

        return view('housekeeper.inventory.index', compact('inventory', 'user'));
    }

    /**
     * Show inventory item details
     */
    public function inventoryShow(Inventory $inventory)
    {
        $sessionUser = SessionFacade::get('user');
        $user = (object)$sessionUser;

        return view('housekeeper.inventory.show', compact('inventory', 'user'));
    }
}
