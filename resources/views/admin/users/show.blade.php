<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <style>
        :root {
            --primary: #4e73df;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --dark: #5a5c69;
            --light: #f8f9fc;
        }

    body {
        background-color: #f4f6f9;
        font-family: 'Nunito', sans-serif;
        color: #333;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        margin-bottom: 1.5rem;
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e3e6f0;
        font-weight: bold;
        color: var(--primary);
        border-radius: 12px 12px 0 0 !important;
        padding: 1rem 1.25rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .btn {
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 600;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
        border: none;
    }

    .btn-primary { background-color: var(--primary); color: white; }
    .btn-light { background-color: var(--light); color: #333; border: 1px solid #ddd; }
    
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table thead th {
        background-color: var(--light);
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.05rem;
        border: none;
        padding: 1rem;
        text-align: left;
    }

    .table td {
        padding: 1rem;
        border-bottom: 1px solid #e3e6f0;
    }

    .badge {
        padding: 0.5em 0.8em;
        border-radius: 6px;
        font-weight: 600;
    }

    .bg-success { background-color: var(--success); color: white; }
    .bg-danger { background-color: var(--danger); color: white; }
    .bg-secondary { background-color: var(--dark); color: white; }

    .user-profile-img {
        width: 100px;
        height: 100px;
        background: var(--light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 40px;
        color: var(--dark);
    }

    .text-center { text-align: center; }
    .text-start { text-align: left; }
    .text-muted { color: #6c757d; }
    .fw-bold { font-weight: bold; }
    .mb-3 { margin-bottom: 1rem; }

    .row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .row .col-md-4 { grid-column: span 1; }
    .row .col-md-8 { grid-column: span 2; }

    @media (max-width: 768px) {
        .row .col-md-8 { grid-column: span 1; }
    }

    hr {
        border: none;
        border-top: 1px solid #e3e6f0;
        margin: 1rem 0;
    }

    .back-link {
        text-decoration: none;
        color: var(--primary);
        margin-bottom: 20px;
        display: inline-block;
        font-weight: 600;
    }
</style>
</head>
<body>
<div class="container">
    <a href="{{ route('admin.users.index') }}" class="back-link">← Back to Users</a>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="user-profile-img">👤</div>
                    <h4 class="fw-bold">{{ $user->name }}</h4>
                    <p class="text-muted">{{ ucfirst($user->role) }}</p>
                    <div class="badge bg-{{ $user->status == 'active' ? 'success' : 'danger' }} mb-3">
                        {{ ucfirst($user->status) }}
                    </div>
                    <hr>
                    <div class="text-start">
                        <small class="text-muted">Email</small>
                        <p class="fw-bold">{{ $user->email }}</p>
                        <small class="text-muted">Phone</small>
                        <p class="fw-bold">{{ $user->phone ?? 'Not set' }}</p>
                        <small class="text-muted">Member Since</small>
                        <p class="fw-bold">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                    <div style="margin-top: 1rem;">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Assigned Tasks</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->tasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td><span class="badge bg-secondary">{{ $task->status }}</span></td>
                                <td>{{ $task->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No tasks assigned yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
