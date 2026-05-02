<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housekeeper Management - Supervisor</title>
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

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
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
            border: 1px solid #7a7a7a;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            background: #666666;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
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
            background: #f7f7f7;
            color: #333;
            border: 1px solid #e0e0e0;
            padding: 8px 15px;
            border-radius: 6px;
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
            margin-right: 5px;
        }

        .btn-view:hover {
            background: #333333;
            transform: translateY(-2px);
        }

        .status-pill {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .active { background: #e6ffed; color: #2ecc71; }
        .inactive { background: #ffeef0; color: #e74c3c; }

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

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        h1 {
            color: #222222;
            font-size: 28px;
            font-weight: 700;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="/supervisor/dashboard" class="btn btn-light">← Back to Dashboard</a>

    <div class="card">
        <div class="card-header">
            <div class="role-badge">SUPERVISOR</div>
            <div class="header-section">
                <h1>Housekeeper Management</h1>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($housekeepers as $housekeeper)
                    <tr>
                        <td><strong>{{ $housekeeper->name }}</strong></td>
                        <td>{{ $housekeeper->email }}</td>
                        <td>{{ $housekeeper->phone ?? 'N/A' }}</td>
                        <td>
                            <span class="status-pill {{ $housekeeper->status == 'active' ? 'active' : 'inactive' }}">
                                {{ $housekeeper->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('supervisor.housekeepers.show', $housekeeper->id) }}" class="btn btn-view">View Details</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No housekeepers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($housekeepers->hasPages())
            <div class="pagination" style="margin-top: 20px; text-align: center;">
                {{ $housekeepers->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>
