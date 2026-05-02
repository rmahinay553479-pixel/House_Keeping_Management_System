<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Tasks - Supervisor</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f0f0f0 0%, #e8e8e8 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .btn-light {
            text-decoration: none;
            display: inline-block;
            margin-bottom: 1rem;
            padding: 8px 15px;
            background: #f7f7f7;
            color: #333;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-light:hover {
            background: #ffffff;
            border-color: #333333;
            transform: translateY(-2px);
        }

        .btn-primary {
            background: #4a4a4a;
            color: white;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-primary:hover {
            background: #333333;
            transform: translateY(-2px);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #333333;
            overflow: hidden;
            background: white;
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 2px solid #e3e6f0;
            font-weight: bold;
            color: #333333;
            padding: 1.5rem 1.5rem;
            font-size: 1.25rem;
        }

        .card-body {
            padding: 2rem;
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

        .role-badge {
            display: inline-block;
            background: linear-gradient(135deg, #333333 0%, #555555 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h1 {
            color: #222222;
            font-size: 28px;
            font-weight: 700;
        }

        .priority-high { background: #ffe6e6; color: #c41e3a; }
        .priority-medium { background: #fff4e6; color: #ff9800; }
        .priority-low { background: #e6f7ff; color: #0066cc; }

        .status-pending { background: #fff4e6; color: #ff9800; }
        .status-completed { background: #e6ffed; color: #2ecc71; }
        .status-approved { background: #e6f7ff; color: #0066cc; }

        .badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="/supervisor/dashboard" class="btn-light">← Back to Dashboard</a>

    <div class="card">
        <div class="card-header">
            <div class="role-badge">SUPERVISOR</div>
            <div class="header-section">
                <h1>All Tasks</h1>
                <a href="{{ route('supervisor.tasks.create') }}" class="btn-light btn-primary">+ Create New Task</a>
            </div>
        </div>
        <div class="card-body">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Assigned To</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                    <tr>
                        <td><strong>{{ $task->title }}</strong></td>
                        <td>{{ $task->user->name ?? 'Unassigned' }}</td>
                        <td>
                            <span class="badge priority-{{ $task->priority }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge status-{{ $task->status }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </td>
                        <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #999;">No tasks found. <a href="{{ route('supervisor.tasks.create') }}">Create one</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($tasks->hasPages())
            <div class="pagination" style="margin-top: 20px; text-align: center;">
                {{ $tasks->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>
