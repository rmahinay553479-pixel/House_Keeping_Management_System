<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management - House Keeping</title>
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

        .in_stock { background: #d4edda; color: #155724; }
        .low_stock { background: #fff3cd; color: #856404; }
        .out_of_stock { background: #f8d7da; color: #721c24; }

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
                <h1>Inventory Management</h1>
                <a href="{{ route('admin.inventory.create') }}" class="btn btn-add">+ Add Item</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" class="filters">
                <div class="filter-group">
                    <label>Category:</label>
                    <select name="category" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label>Status:</label>
                    <select name="status" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="in_stock" {{ request('status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                        <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Search:</label>
                    <input type="text" name="search" placeholder="Item name..." value="{{ request('search') }}">
                </div>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Status</th>
                        <th>Supplier</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventory as $item)
                    <tr>
                        <td><strong>{{ $item->name }}</strong></td>
                        <td>{{ ucfirst($item->category) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>
                            <span class="status-pill {{ str_replace(' ', '_', $item->status) }}">
                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                            </span>
                        </td>
                        <td>{{ $item->supplier ?? 'N/A' }}</td>
                        <td style="display: flex; gap: 5px;">
                            <a href="{{ route('admin.inventory.show', $item->id) }}" class="btn btn-view">View</a>
                            <a href="{{ route('admin.inventory.edit', $item->id) }}" class="btn btn-edit">Edit</a>
                            <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">No items found. <a href="{{ route('admin.inventory.create') }}">Add one</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($inventory->hasPages())
            <div class="pagination">
                {{ $inventory->links() }}
            </div>
            @endif
        </div>
    </div>
</body>
</html>
