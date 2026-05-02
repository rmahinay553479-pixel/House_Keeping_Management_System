<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - HMS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f0f0f0 0%, #e8e8e8 100%);
            min-height: 100vh;
        }

        /* Navbar Style */
        .navbar {
            background: linear-gradient(135deg, #4a4a4a 0%, #5a5a5a 100%);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .navbar h2 { font-size: 24px; font-weight: 600; }

        .logout-btn {
            background: #555555;
            color: white;
            padding: 8px 16px;
            border: 1px solid #666666;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .logout-btn:hover { background: #666; transform: translateY(-2px); }

        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* Dashboard Content */
        .dashboard-content {
            background: #ffffff;
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #333333;
        }

        .role-badge {
            display: inline-block;
            background: linear-gradient(135deg, #333333 0%, #555555 100%);
            color: white;
            padding: 8px 25px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        h1 { color: #222; margin-bottom: 30px; }

        /* Feature Cards Grid */
        .features {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .feature-link { text-decoration: none; color: inherit; }

        .feature-card {
            background: #f7f7f7;
            padding: 25px 20px;
            border-radius: 15px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
            text-align: center;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: #333;
            background: #fff;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .feature-card h3 { margin-bottom: 10px; font-size: 18px; color: #333; }
        .feature-card p { font-size: 13px; color: #666; }

        /* Integrated Table Style */
        .management-section {
            margin-top: 50px;
            text-align: left;
            border-top: 1px solid #eee;
            padding-top: 30px;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-size: 13px;
            text-transform: uppercase;
            color: #777;
            border-bottom: 2px solid #eee;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
            color: #333;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            text-decoration: none;
            font-weight: bold;
            margin-right: 5px;
            display: inline-block;
        }

        .btn-edit { background: #4a90e2; color: white; }
        .btn-view { background: #2ecc71; color: white; }
        .btn-delete { background: #e74c3c; color: white; border: none; cursor: pointer; }

        .status-active { color: #2ecc71; font-weight: bold; }
        .status-inactive { color: #e74c3c; font-weight: bold; }

        @media (max-width: 1024px) { .features { grid-template-columns: repeat(2, 1fr); } }
    </style>
</head>
<body>

    <div class="navbar">
        <h2>House Keeping Management</h2>
        <div class="navbar-right" style="display: flex; align-items: center; gap: 20px;">
            <p>Welcome, <strong>{{ session('user')['name'] ?? 'Admin' }}</strong></p>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="dashboard-content">
            <div class="role-badge">ADMIN CONTROL PANEL</div>
            <h1>Dashboard Overview</h1>

            <div class="features">
                <a href="{{ route('admin.users.index') }}" class="feature-link">
                    <div class="feature-card" style="border-bottom: 4px solid #4a90e2;">
                        <h3>User Management</h3>
                        <p>Total Users: {{ \App\Models\User::count() }}</p>
                    </div>
                </a>

                <a href="{{ route('admin.inventory.index') }}" class="feature-link">
                    <div class="feature-card" style="border-bottom: 4px solid #2ecc71;">
                        <h3>Inventory</h3>
                        <p>Manage supplies and stocks.</p>
                    </div>
                </a>

                <a href="{{ route('admin.tasks.index') }}" class="feature-link">
                    <div class="feature-card" style="border-bottom: 4px solid #f6c23e;">
                        <h3>All Tasks</h3>
                        <p>Monitor cleaning schedules.</p>
                    </div>
                </a>

                <a href="{{ route('admin.reports.index') }}" class="feature-link">
                    <div class="feature-card" style="border-bottom: 4px solid #e74c3c;">
                        <h3>Reports</h3>
                        <p>Performance & Analytics.</p>
                    </div>
                </a>
            </div>

            <div class="management-section">
                <div class="table-header">
                    <h2 style="font-size: 20px; color: #333;">Recent Registered Users</h2>
                    <a href="{{ route('admin.users.create') }}" class="logout-btn" style="background: #333;">+ Add New User</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\User::latest()->take(5)->get() as $user)
                        <tr>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>
                                <span class="{{ $user->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                    ● {{ strtoupper($user->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn-action btn-view">View</a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-action btn-edit">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p style="margin-top: 15px; font-size: 13px; color: #888;">Showing last 5 registered users. Click User Management card to see all.</p>
            </div>
        </div>
    </div>

</body>
</html>