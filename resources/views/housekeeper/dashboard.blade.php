<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housekeeper Dashboard</title>
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

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: linear-gradient(135deg, #4a4a4a 0%, #5a5a5a 100%);
            color: white;
            padding: 25px 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
            <p><strong>{{ $user->name }}</strong></p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <div class="dashboard-content">
        <div class="role-badge">HOUSEKEEPER</div>
        <h1>Welcome, {{ $user->name }}</h1>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-value">{{ $totalTasks }}</div>
                <div class="stat-label">Total Tasks Assigned</div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #555555 0%, #3a3a3a 100%);">
                <div class="stat-value">{{ $completedTasks }}</div>
                <div class="stat-label">Completed Tasks</div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #3a3a3a 0%, #555555 100%);">
                <div class="stat-value">{{ $pendingTasks }}</div>
                <div class="stat-label">Pending Tasks</div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #4a4a4a 0%, #6a6a6a 100%);">
                <div class="stat-value">{{ $approvedTasks }}</div>
                <div class="stat-label">Approved Tasks</div>
            </div>
        </div>

        <div class="features">
            <a href="{{ route('housekeeper.tasks.index') }}" class="feature-card">
                <h3>My Tasks</h3>
                <p>View and manage all tasks assigned to you. Update task status and track progress.</p>
            </a>

            <a href="{{ route('housekeeper.profile.show') }}" class="feature-card">
                <h3>My Profile</h3>
                <p>View your personal information, contact details, and role assignment.</p>
            </a>

            <a href="{{ route('housekeeper.inventory.index') }}" class="feature-card">
                <h3>Inventory</h3>
                <p>Check available supplies, chemicals, and tools for your daily work.</p>
            </a>
        </div>
    </div>
</div>

</body>
</html>