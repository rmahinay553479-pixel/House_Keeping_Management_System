<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - Housekeeper</title>
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
            padding: 0;
        }

        .navbar {
            background: linear-gradient(135deg, #4a4a4a 0%, #5a5a5a 100%);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .navbar h2 {
            font-size: 24px;
            font-weight: 600;
        }

        .logout-btn {
            background: #555555;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: #666666;
            transform: translateY(-2px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
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

        .btn-view {
            background: #4a4a4a;
            color: white;
        }

        .btn-view:hover {
            background: #333333;
            transform: translateY(-2px);
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

        .status-low { background: #ffe6e6; color: #c41e3a; }
        .status-medium { background: #fff4e6; color: #ff9800; }
        .status-ok { background: #e6ffed; color: #2ecc71; }

        .badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        h1 {
            color: #222222;
            font-size: 28px;
            font-weight: 700;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 20px;
        }

        .pagination a, .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }

        .pagination a:hover {
            background: #f7f7f7;
        }

        .pagination .active {
            background: #4a4a4a;
            color: white;
            border-color: #4a4a4a;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h2>House Keeping Management</h2>
    <div class="navbar-right">
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <a href="{{ route('housekeeper.dashboard') }}" class="btn-light">← Back to Dashboard</a>

    <div class="card">
        <div class="card-header">
            <div class="role-badge">HOUSEKEEPER</div>
            <h1>Inventory Items</h1>
        </div>
        <div class="card-body">
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Stock Status</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventory as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>
                                @if($item->quantity <= 5)
                                    <span class="badge status-low">Low Stock</span>
                                @elseif($item->quantity <= 15)
                                    <span class="badge status-medium">Medium Stock</span>
                                @else
                                    <span class="badge status-ok">OK</span>
                                @endif
                            </td>
                            <td>{{ $item->location ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('housekeeper.inventory.show', $item->id) }}" class="btn btn-view">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px;">No inventory items available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination">
                {{ $inventory->links() }}
            </div>
        </div>
    </div>
</div>

</body>
</html>
