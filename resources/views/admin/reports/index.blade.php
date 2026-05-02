<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - House Keeping Management</title>
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
            max-width: 1400px;
            margin: 0 auto;
        }

        .back-link {
            text-decoration: none;
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
            display: inline-block;
        }

        .report-header {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #333333;
            margin-bottom: 30px;
        }

        .header-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        h1 {
            color: #222222;
            font-size: 28px;
            font-weight: 700;
        }

        .filter-group {
            display: flex;
            gap: 15px;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .date-input {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .date-input label {
            font-weight: 600;
            color: #333;
            font-size: 13px;
        }

        .date-input input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: 0.2s;
            cursor: pointer;
            border: none;
            display: inline-block;
        }

        .btn-primary {
            background: #333;
            color: white;
        }

        .btn-primary:hover {
            background: #444;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-top: 4px solid #333;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #333;
            margin: 10px 0;
        }

        .stat-label {
            font-size: 13px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-badge {
            display: inline-block;
            background: #f0f0f0;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            margin-top: 10px;
            color: #333;
        }

        .content-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f7f7f7;
            padding: 15px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            color: #666;
            border-bottom: 2px solid #e0e0e0;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            color: #555;
            font-size: 14px;
        }

        tr:hover {
            background: #f9f9f9;
        }

        .priority-badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }

        .high { background: #ff4d4d; color: white; }
        .medium { background: #ffc107; color: white; }
        .low { background: #28a745; color: white; }

        .chart-container {
            margin: 30px 0;
            text-align: center;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
        }

        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: 1fr; }
            .grid-2 { grid-template-columns: 1fr; }
            .filter-group { flex-direction: column; align-items: stretch; }
            .date-input input { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/admin/dashboard" class="back-link">← Back to Dashboard</a>

        <div class="report-header">
            <div class="header-title">
                <h1>Reports & Analytics</h1>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <form method="POST" action="{{ route('admin.reports.export') }}" style="margin: 0;">
                        @csrf
                        <input type="hidden" name="from" value="{{ $dateFrom }}">
                        <input type="hidden" name="to" value="{{ $dateTo }}">
                        <input type="hidden" name="format" value="pdf">
                        <button type="submit" class="btn btn-primary">📄 Download PDF</button>
                    </form>
                    <form method="POST" action="{{ route('admin.reports.export') }}" style="margin: 0;">
                        @csrf
                        <input type="hidden" name="from" value="{{ $dateFrom }}">
                        <input type="hidden" name="to" value="{{ $dateTo }}">
                        <input type="hidden" name="format" value="csv">
                        <button type="submit" class="btn btn-primary">📊 Download CSV</button>
                    </form>
                </div>
            </div>

            <form method="GET" class="filter-group">
                <div class="date-input">
                    <label>From Date</label>
                    <input type="date" name="from" value="{{ $dateFrom }}">
                </div>
                <div class="date-input">
                    <label>To Date</label>
                    <input type="date" name="to" value="{{ $dateTo }}">
                </div>
                <button type="submit" class="btn btn-primary">Filter Report</button>
            </form>
        </div>

        <!-- Key Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Tasks</div>
                <div class="stat-value">{{ $taskStats['total'] }}</div>
                <div class="stat-badge">{{ \Carbon\Carbon::parse($dateFrom)->format('M d') }} - {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Completed</div>
                <div class="stat-value" style="color: #2ecc71;">{{ $taskStats['completed'] }}</div>
                <div class="stat-badge">{{ $taskStats['completion_rate'] }}% completion rate</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">In Progress</div>
                <div class="stat-value" style="color: #f6c23e;">{{ $taskStats['in_progress'] }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Pending</div>
                <div class="stat-value" style="color: #e74c3c;">{{ $taskStats['pending'] }}</div>
            </div>
        </div>

        <!-- Inventory Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Items</div>
                <div class="stat-value">{{ $inventoryStats['total_items'] }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Low Stock</div>
                <div class="stat-value" style="color: #f6c23e;">{{ $inventoryStats['low_stock'] }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Out of Stock</div>
                <div class="stat-value" style="color: #e74c3c;">{{ $inventoryStats['out_of_stock'] }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Total Value</div>
                <div class="stat-value" style="color: #4a90e2;">₱{{ number_format($inventoryStats['total_value'] ?? 0, 2) }}</div>
            </div>
        </div>

        <!-- Tasks by Priority -->
        <div class="content-card">
            <div class="card-title">Tasks by Priority</div>
            <table>
                <thead>
                    <tr>
                        <th>Priority</th>
                        <th>Count</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasksByPriority as $priority => $count)
                    <tr>
                        <td><span class="priority-badge {{ $priority }}">{{ ucfirst($priority) }}</span></td>
                        <td>{{ $count }}</td>
                        <td>{{ $taskStats['total'] > 0 ? round(($count / $taskStats['total']) * 100, 1) : 0 }}%</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center;">No tasks found for this period.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Staff Performance -->
        <div class="content-card">
            <div class="card-title">Staff Performance</div>
            <table>
                <thead>
                    <tr>
                        <th>Staff Member</th>
                        <th>Total Tasks</th>
                        <th>Completed</th>
                        <th>Completion Rate</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staffPerformance as $staff)
                    <tr>
                        <td><strong>{{ $staff->name }}</strong></td>
                        <td>{{ $staff->total_tasks }}</td>
                        <td>{{ $staff->completed_tasks }}</td>
                        <td>{{ $staff->total_tasks > 0 ? round(($staff->completed_tasks / $staff->total_tasks) * 100, 1) : 0 }}%</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">No staff performance data available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Low Stock Alerts -->
        <div class="content-card">
            <div class="card-title">⚠️ Low & Out of Stock Alerts</div>
            @if($lowStockItems->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Current Qty</th>
                        <th>Min Level</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockItems as $item)
                    <tr>
                        <td><strong>{{ $item->name }}</strong></td>
                        <td>{{ ucfirst($item->category) }}</td>
                        <td>{{ $item->quantity }} {{ $item->unit }}</td>
                        <td>{{ $item->min_stock_level }} {{ $item->unit }}</td>
                        <td>
                            <span class="priority-badge" style="background: {{ $item->status == 'out_of_stock' ? '#e74c3c' : '#ffc107' }}; color: white;">
                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p style="text-align: center; color: #666; padding: 20px;">✅ All inventory levels are good!</p>
            @endif
        </div>

        <!-- Daily Task Trends -->
        <div class="content-card">
            <div class="card-title">Daily Task Trends (Last 30 Days)</div>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Total Tasks</th>
                        <th>Completed</th>
                        <th>Completion Rate</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($taskTrends as $trend)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($trend->date)->format('M d, Y') }}</td>
                        <td>{{ $trend->total }}</td>
                        <td>{{ $trend->completed ?? 0 }}</td>
                        <td>{{ $trend->total > 0 ? round((($trend->completed ?? 0) / $trend->total) * 100, 1) : 0 }}%</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">No task trends available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
