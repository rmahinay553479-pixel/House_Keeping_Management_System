<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with('assignee');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('date')) {
            $query->whereDate('scheduled_date', $request->date);
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $tasks = $query->latest('scheduled_date')->paginate(15);
        $cleaners = User::where('role', 'cleaner')->get();

        return view('admin.tasks.index', compact('tasks', 'cleaners'));
    }

    public function create()
    {
        $cleaners = User::where('role', 'cleaner')->get();
        return view('admin.tasks.create', compact('cleaners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'nullable|date_format:H:i',
            'priority' => 'required|in:low,medium,high',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'pending';

        Task::create($validated);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $task->load('assignee');
        return view('admin.tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $cleaners = User::where('role', 'cleaner')->get();
        return view('admin.tasks.edit', compact('task', 'cleaners'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'nullable|date_format:H:i',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        if ($validated['status'] === 'completed' && $task->status !== 'completed') {
            $validated['completed_at'] = now();
        }

        $task->update($validated);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $task->status = $validated['status'];
        
        if ($validated['status'] === 'completed') {
            $task->completed_at = now();
        }

        $task->save();

        return back()->with('success', 'Task status updated.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}
