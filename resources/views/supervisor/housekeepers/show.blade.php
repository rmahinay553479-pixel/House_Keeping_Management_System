<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housekeeper Details - Supervisor</title>
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
            padding: 40px 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
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

        .info-section {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #eee;
        }

        .info-section:last-child {
            border-bottom: none;
        }

        .info-row {
            display: grid;
            grid-template-columns: 150px 1fr;
            margin-bottom: 1rem;
        }

        .info-label {
            font-weight: 600;
            color: #333333;
        }

        .info-value {
            color: #555;
        }

        .status-pill {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .active { background: #e6ffed; color: #2ecc71; }
        .inactive { background: #ffeef0; color: #e74c3c; }

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
        }

        h2 {
            color: #222222;
            font-size: 22px;
            font-weight: 700;
            margin-top: 0;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="{{ route('supervisor.housekeepers.index') }}" class="btn-light">← Back to Housekeepers</a>

    <div class="card">
        <div class="card-header">
            <div class="role-badge">SUPERVISOR</div>
            <h2>{{ $user->name }} - Details</h2>
        </div>
        <div class="card-body">
            <div class="info-section">
                <h3 style="margin-bottom: 1rem; color: #333;">Personal Information</h3>
                
                <div class="info-row">
                    <div class="info-label">Name:</div>
                    <div class="info-value">{{ $user->name }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $user->email }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Phone:</div>
                    <div class="info-value">{{ $user->phone ?? 'N/A' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Role:</div>
                    <div class="info-value">{{ ucfirst($user->role) }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Status:</div>
                    <div class="info-value">
                        <span class="status-pill {{ $user->status == 'active' ? 'active' : 'inactive' }}">
                            {{ $user->status }}
                        </span>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Joined:</div>
                    <div class="info-value">{{ $user->created_at->format('M d, Y') }}</div>
                </div>
            </div>

            @if($user->tasks->count() > 0)
            <div class="info-section">
                <h3 style="margin-bottom: 1rem; color: #333;">Assigned Tasks</h3>
                
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->tasks as $task)
                        <tr>
                            <td><strong>{{ $task->title }}</strong></td>
                            <td>
                                <span style="padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: bold;
                                    @if($task->priority === 'high') background: #ffe6e6; color: #c41e3a;
                                    @elseif($task->priority === 'medium') background: #fff4e6; color: #ff9800;
                                    @else background: #e6f7ff; color: #0066cc; @endif
                                ">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>
                            <td>
                                <span style="padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: bold;
                                    @if($task->status === 'completed') background: #e6ffed; color: #2ecc71;
                                    @elseif($task->status === 'pending') background: #fff4e6; color: #ff9800;
                                    @else background: #e6f7ff; color: #0066cc; @endif
                                ">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                            <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="info-section">
                <p style="color: #999;">No tasks assigned yet.</p>
            </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>
