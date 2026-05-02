<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management - House Keeping</title>
    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f0f0f0 0%, #e8e8e8 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .management-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #333333;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .role-badge {
            display: inline-block;
            background: linear-gradient(135deg, #333333 0%, #555555 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        h1 {
            color: #222222;
            font-size: 28px;
            font-weight: 700;
        }

        .filters {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .filter-group label {
            font-weight: 600;
            color: #333;
        }

        .filter-group select, .filter-group input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: 0.2s;
            cursor: pointer;
            border: none;
            display: inline-block;
        }

        .btn-add {
            background: #333;
            color: white;
        }

        .btn-view {
            background: #4e73df;
            color: white;
        }

        .btn-edit {
            background: #f0f0f0;
            color: #333;
            border: 1px solid #ccc;
            margin-right: 5px;
        }

        .btn-delete {
            background: #ff4d4d;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            text-align: left;
            background: #f7f7f7;
            padding: 15px;
            border-bottom: 2px solid #e0e0e0;
            color: #333;
            font-size: 14px;
            text-transform: uppercase;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            color: #555;
            font-size: 15px;
        }

        tr:hover {
            background-color: #fafafa;
        }

        .status-pill {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }

        .pending { background: #fff3cd; color: #856404; }
        .in_progress { background: #d1ecf1; color: #0c5460; }
        .completed { background: #d4edda; color: #155724; }
        .cancelled { background: #f8d7da; color: #721c24; }

        .priority-badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .priority-high { background: #ff4d4d; color: white; }
        .priority-medium { background: #ffc107; color: white; }
        .priority-low { background: #28a745; color: white; }

        .back-link {
            text-decoration: none;
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
            display: inline-block;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 25px;
            gap: 5px;
        }

        .pagination a, .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
        }

        .pagination .active span {
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/admin/dashboard" class="back-link">← Back to Dashboard</a>

        <div class="management-card">
            <div class="role-badge">ADMIN MANAGEMENT</div>

            <div class="header-section">
                <h1>Task Management</h1>
                <a href="{{ route('admin.tasks.create') }}" class="btn btn-add">+ Create Task</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" class="filters">
                <div class="filter-group">
                    <label>Status:</label>
                    <select name="status" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Priority:</label>
                    <select name="priority" onchange="this.form.submit()">
                        <option value="">All Priorities</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Assigned To:</label>
                    <select name="assigned_to" onchange="this.form.submit()">
                        <option value="">All Users</option>
                        @foreach($cleaners as $cleaner)
                            <option value="{{ $cleaner->id }}" {{ request('assigned_to') == $cleaner->id ? 'selected' : '' }}>
                                {{ $cleaner->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Assigned To</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Scheduled Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                    <tr>
                        <td><strong>{{ $task->title }}</strong></td>
                        <td>{{ $task->assignee?->name ?? 'Unassigned' }}</td>
                        <td>
                            <span class="priority-badge priority-{{ $task->priority }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </td>
                        <td>
                            <span class="status-pill {{ str_replace(' ', '_', $task->status) }}">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </td>
                        <td>{{ $task->scheduled_date->format('M d, Y') }}</td>
                        <td style="display: flex; gap: 5px;">
                            <a href="{{ route('admin.tasks.show', $task->id) }}" class="btn btn-view">View</a>
                            <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-edit">Edit</a>
                            <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">No tasks found. <a href="{{ route('admin.tasks.create') }}">Create one</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($tasks->hasPages())
            <div class="pagination">
                {{ $tasks->links() }}
            </div>
            @endif
        </div>
    </div>
</body>
</html>
