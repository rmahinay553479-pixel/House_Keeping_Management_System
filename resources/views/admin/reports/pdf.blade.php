<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Keeping Management Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .container {
            padding: 20px;
            max-width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .report-info {
            text-align: center;
            color: #666;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .section-title {
            background-color: #f0f0f0;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            color: #333;
            border-left: 4px solid #333;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 15px;
        }

        .stat-box {
            background-color: #f5f5f5;
            padding: 15px;
            border-left: 4px solid #4e73df;
            page-break-inside: avoid;
        }

        .stat-label {
            color: #666;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #999;
            font-size: 12px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>House Keeping Management System</h1>
            <p style="color: #666; margin-top: 5px;">Performance Report</p>
        </div>

        <div class="report-info">
            <p><strong>Generated:</strong> {{ now()->format('F d, Y - H:i A') }}</p>
            <p><strong>Report Period:</strong> {{ \Carbon\Carbon::parse($dateFrom)->format('F d, Y') }} to {{ \Carbon\Carbon::parse($dateTo)->format('F d, Y') }}</p>
        </div>

        <!-- Task Statistics Section -->
        <div class="section">
            <div class="section-title">📋 Task Statistics</div>
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-label">Total Tasks</div>
                    <div class="stat-value">{{ $taskStats['total'] }}</div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">Completed</div>
                    <div class="stat-value">{{ $taskStats['completed'] }}</div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">In Progress</div>
                    <div class="stat-value">{{ $taskStats['in_progress'] }}</div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">Pending</div>
                    <div class="stat-value">{{ $taskStats['pending'] }}</div>
                </div>
            </div>
            
            <table>
                <tr>
                    <th>Metric</th>
                    <th>Value</th>
                </tr>
                <tr>
                    <td>Completion Rate</td>
                    <td><strong>{{ $taskStats['completion_rate'] }}%</strong></td>
                </tr>
            </table>
        </div>

        <!-- Tasks by Priority -->
        @if($tasksByPriority->count() > 0)
        <div class="section">
            <div class="section-title">⚡ Tasks by Priority</div>
            <table>
                <tr>
                    <th>Priority</th>
                    <th>Count</th>
                </tr>
                @foreach($tasksByPriority as $priority => $count)
                <tr>
                    <td>{{ ucfirst($priority) }}</td>
                    <td>{{ $count }}</td>
                </tr>
                @endforeach
            </table>
        </div>
        @endif

        <!-- Inventory Statistics Section -->
        <div class="section">
            <div class="section-title">📦 Inventory Statistics</div>
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-label">Total Items</div>
                    <div class="stat-value">{{ $inventoryStats['total_items'] }}</div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">Low Stock</div>
                    <div class="stat-value">{{ $inventoryStats['low_stock'] }}</div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">Out of Stock</div>
                    <div class="stat-value">{{ $inventoryStats['out_of_stock'] }}</div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">Total Value</div>
                    <div class="stat-value">₱{{ number_format($inventoryStats['total_value'] ?? 0, 2) }}</div>
                </div>
            </div>
        </div>

        <!-- Low Stock Items -->
        @if($lowStockItems->count() > 0)
        <div class="section">
            <div class="section-title">⚠️ Low Stock & Out of Stock Items</div>
            <table>
                <tr>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Current Qty</th>
                    <th>Unit</th>
                    <th>Min Level</th>
                    <th>Status</th>
                </tr>
                @foreach($lowStockItems as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->min_stock_level }}</td>
                    <td>
                        <span style="background-color: {{ $item->status === 'out_of_stock' ? '#e74a3b' : '#f39c12' }}; color: white; padding: 3px 8px; border-radius: 3px; font-size: 11px;">
                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        @endif

        <div class="footer">
            <p>This report is confidential and intended for authorized personnel only.</p>
            <p>© {{ now()->year }} House Keeping Management System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
