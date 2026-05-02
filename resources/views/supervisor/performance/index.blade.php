<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housekeeper Performance - Supervisor</title>
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

        .progress-bar {
            width: 100%;
            height: 20px;
            background: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            display: inline-block;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #4a4a4a 0%, #333333 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        h1 {
            color: #222222;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 0;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #4a4a4a 0%, #5a5a5a 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-value {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="/supervisor/dashboard" class="btn-light">← Back to Dashboard</a>

    <div class="card">
        <div class="card-header">
            <div class="role-badge">SUPERVISOR</div>
            <h1>Housekeeper Performance Metrics</h1>
        </div>
        <div class="card-body">
            <div class="stats">
                <div class="stat-card">
                    <div class="stat-value">{{ $performanceData->count() }}</div>
                    <div class="stat-label">Total Housekeepers</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="stat-value">{{ $performanceData->sum('totalTasks') }}</div>
                    <div class="stat-label">Total Tasks</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <div class="stat-value">{{ $performanceData->sum('completedTasks') }}</div>
                    <div class="stat-label">Completed Tasks</div>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Total Tasks</th>
                        <th>Completed</th>
                        <th>Pending</th>
                        <th>Completion Rate</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($performanceData as $data)
                    <tr>
                        <td><strong>{{ $data['name'] }}</strong></td>
                        <td>{{ $data['email'] }}</td>
                        <td>{{ $data['totalTasks'] }}</td>
                        <td><span style="background: #e6ffed; color: #2ecc71; padding: 4px 8px; border-radius: 4px; font-weight: bold;">{{ $data['completedTasks'] }}</span></td>
                        <td><span style="background: #fff4e6; color: #ff9800; padding: 4px 8px; border-radius: 4px; font-weight: bold;">{{ $data['pendingTasks'] }}</span></td>
                        <td>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $data['completionRate'] }}%;">
                                    {{ $data['completionRate'] }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #999;">No housekeepers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
