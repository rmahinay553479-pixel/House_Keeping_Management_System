<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Supervisor</title>
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            padding: 20px;
            border-radius: 8px;
            color: white;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stat-value {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }

        .stat-card-1 { background: linear-gradient(135deg, #4a4a4a 0%, #5a5a5a 100%); }
        .stat-card-2 { background: linear-gradient(135deg, #555555 0%, #3a3a3a 100%); }
        .stat-card-3 { background: linear-gradient(135deg, #3a3a3a 0%, #555555 100%); }
        .stat-card-4 { background: linear-gradient(135deg, #4a4a4a 0%, #6a6a6a 100%); }
        .stat-card-5 { background: linear-gradient(135deg, #5a5a5a 0%, #3a3a3a 100%); }
        .stat-card-6 { background: linear-gradient(135deg, #3a3a3a 0%, #5a5a5a 100%); }

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

        h1 {
            color: #222222;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        h3 {
            color: #333;
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            text-align: left;
            background: #f7f7f7;
            padding: 12px;
            border-bottom: 2px solid #e0e0e0;
            color: #333;
            font-size: 13px;
            text-transform: uppercase;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            color: #555;
            font-size: 14px;
        }

        tr:hover {
            background-color: #fafafa;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="/supervisor/dashboard" class="btn-light">← Back to Dashboard</a>

    <div class="card">
        <div class="card-header">
            <div class="role-badge">SUPERVISOR</div>
            <h1>Performance & Analytics Reports</h1>
        </div>
        <div class="card-body">
            <div class="stats-grid">
                <div class="stat-card stat-card-1">
                    <div class="stat-value">{{ $totalHousekeepers }}</div>
                    <div class="stat-label">Total Housekeepers</div>
                </div>
                <div class="stat-card stat-card-2">
                    <div class="stat-value">{{ $totalTasks }}</div>
                    <div class="stat-label">Total Tasks</div>
                </div>
                <div class="stat-card stat-card-3">
                    <div class="stat-value">{{ $completedTasks }}</div>
                    <div class="stat-label">Approved Tasks</div>
                </div>
                <div class="stat-card stat-card-4">
                    <div class="stat-value">{{ $pendingTasks }}</div>
                    <div class="stat-label">Pending Tasks</div>
                </div>
                <div class="stat-card stat-card-5">
                    <div class="stat-value">{{ $inventoryItems }}</div>
                    <div class="stat-label">Inventory Items</div>
                </div>
                <div class="stat-card stat-card-6">
                    <div class="stat-value">{{ $lowStockItems }}</div>
                    <div class="stat-label">Low Stock Items</div>
                </div>
            </div>

            <h3>Task Status Distribution</h3>
            <table>
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Count</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasksByStatus as $status)
                    <tr>
                        <td><strong>{{ ucfirst($status->status) }}</strong></td>
                        <td>{{ $status->count }}</td>
                        <td>{{ $totalTasks > 0 ? round(($status->count / $totalTasks) * 100, 2) : 0 }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Housekeeper Productivity</h3>
            <table>
                <thead>
                    <tr>
                        <th>Housekeeper Name</th>
                        <th>Completed Tasks</th>
                        <th>Total Tasks</th>
                        <th>Completion Rate</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($housekeeperProductivity as $data)
                    <tr>
                        <td><strong>{{ $data['name'] }}</strong></td>
                        <td>{{ $data['completed'] }}</td>
                        <td>{{ $data['total'] }}</td>
                        <td>
                            <span style="background: #e6f7ff; color: #0066cc; padding: 4px 8px; border-radius: 4px; font-weight: bold;">
                                {{ $data['rate'] }}%
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #999;">No housekeeper data available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
