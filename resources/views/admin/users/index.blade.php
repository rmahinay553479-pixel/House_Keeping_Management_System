<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - House Keeping</title>
    <style>
        /* DASHBOARD STYLE INTEGRATION */
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

        /* CARD STYLE FROM YOUR IMAGE */
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
            text-decoration: none;
            margin-bottom: 10px;
        }

        h1 {
            color: #222222;
            font-size: 28px;
            font-weight: 700;
        }

        /* TABLE STYLE */
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

        /* BUTTONS */
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

        .status-pill {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .active { background: #e6ffed; color: #2ecc71; }
        .inactive { background: #ffeef0; color: #e74c3c; }

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

        .pagination a:hover {
            background-color: #f0f0f0;
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
                <h1>User Management</h1>
                <a href="{{ route('admin.users.create') }}" class="btn btn-add">+ Add New User</a>
            </div>

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
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <span class="status-pill {{ $user->status == 'active' ? 'active' : 'inactive' }}">
                                {{ $user->status }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-edit">Edit</a>
                                
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No users found. <a href="{{ route('admin.users.create') }}">Create one</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($users->hasPages())
            <div class="pagination">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>

</body>
</html>
