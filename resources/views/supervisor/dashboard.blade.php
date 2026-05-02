<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard - House Keeping Management System</title>
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

        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .user-info p {
            font-size: 14px;
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
            max-width: 1300px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .dashboard-content {
            background: #ffffff;
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #333333;
        }

        .dashboard-content h1 {
            color: #222222;
            font-size: 32px;
            margin-bottom: 30px;
            font-weight: 700;
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
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            letter-spacing: 0.5px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .feature-card {
            background: #f7f7f7;
            padding: 25px 20px;
            border-radius: 15px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-decoration: none;
            color: inherit;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            background: #ffffff;
            border-color: #333333;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .feature-card h3 {
            color: #333333;
            margin-bottom: 10px;
            font-size: 18px; 
            font-weight: 600;
        }

        .feature-card p {
            font-size: 13px;
            color: #666;
            line-height: 1.4;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>House Keeping Management</h2>
        <div class="navbar-right">
            <div class="user-info">
                <p><strong>{{ session('user')['name'] }}</strong></p>
            </div>
            <form action="/logout" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="dashboard-content">
            <div class="role-badge">SUPERVISOR</div>
            <h1>Welcome Supervisor Dashboard</h1>

            <div class="features">
                <a href="{{ route('supervisor.housekeepers.index') }}" class="feature-card">
                    <h3>Housekeeper Management</h3>
                    <p>Manage housekeepers, view profiles, and adjust their daily assignments.</p>
                </a>
                <a href="{{ route('supervisor.performance.index') }}" class="feature-card">
                    <h3>Housekeeper Performance</h3>
                    <p>Monitor housekeeper productivity, completion rates, and feedback metrics.</p>
                </a>
                <a href="{{ route('supervisor.tasks.approval') }}" class="feature-card">
                    <h3>Task Approval</h3>
                    <p>Review and verify completed tasks before final submission.</p>
                </a>
                <a href="{{ route('supervisor.tasks.create') }}" class="feature-card">
                    <h3>Create & Assign Tasks</h3>
                    <p>Assign cleaning tasks to housekeepers</p>
                </a>
                <a href="{{ route('supervisor.inventory.index') }}" class="feature-card">
                    <h3>Inventory Oversight</h3>
                    <p>Monitor chemical, tool, and supplies usage across all floors.</p>
                </a>
                <a href="{{ route('supervisor.reports.index') }}" class="feature-card">
                    <h3>Reports</h3>
                    <p>Generate comprehensive team reports and monthly performance analytics.</p>
                </a>
            </div>
        </div>
    </div>
</body>
</html>