<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Item Details - Housekeeper</title>
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
            max-width: 900px;
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

        .info-row {
            display: grid;
            grid-template-columns: 150px 1fr;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #333333;
        }

        .info-value {
            color: #555;
        }

        .status-low { background: #ffe6e6; color: #c41e3a; }
        .status-medium { background: #fff4e6; color: #ff9800; }
        .status-ok { background: #e6ffed; color: #2ecc71; }

        .badge {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: bold;
            display: inline-block;
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

        h2 {
            color: #222222;
            font-size: 22px;
            font-weight: 700;
            margin-top: 0;
        }

        .description-box {
            background: #f7f7f7;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #4a4a4a;
            color: #555;
            line-height: 1.6;
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
    <a href="{{ route('housekeeper.inventory.index') }}" class="btn-light">← Back to Inventory</a>

    <div class="card">
        <div class="card-header">
            <div class="role-badge">HOUSEKEEPER</div>
            <h2>{{ $inventory->item_name }} - Details</h2>
        </div>
        <div class="card-body">
            <div class="info-row">
                <div class="info-label">Item Name:</div>
                <div class="info-value">{{ $inventory->item_name }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Category:</div>
                <div class="info-value">{{ $inventory->category }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Quantity:</div>
                <div class="info-value">{{ $inventory->quantity }} {{ $inventory->unit }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Unit:</div>
                <div class="info-value">{{ $inventory->unit }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Stock Status:</div>
                <div class="info-value">
                    @if($inventory->quantity <= 5)
                        <span class="badge status-low">Low Stock</span>
                    @elseif($inventory->quantity <= 15)
                        <span class="badge status-medium">Medium Stock</span>
                    @else
                        <span class="badge status-ok">OK</span>
                    @endif
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Location:</div>
                <div class="info-value">{{ $inventory->location ?? 'N/A' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Last Updated:</div>
                <div class="info-value">{{ $inventory->updated_at ? $inventory->updated_at->format('M d, Y \a\t g:i A') : 'N/A' }}</div>
            </div>

            @if($inventory->description)
                <div class="info-row">
                    <div class="info-label">Description:</div>
                </div>
                <div class="description-box">
                    {{ $inventory->description }}
                </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>
