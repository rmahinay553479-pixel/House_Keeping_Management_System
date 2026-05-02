<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
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
        max-width: 900px;
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
    .btn-edit { background-color: var(--info); color: white; }

    .info-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .info-item {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid var(--primary);
    }

    .info-label {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }

    .info-value {
        font-size: 1rem;
        color: #333;
        font-weight: 500;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-pending { background: #fff3cd; color: #856404; }
    .status-in_progress { background: #d1ecf1; color: #0c5460; }
    .status-completed { background: #d4edda; color: #155724; }
    .status-cancelled { background: #f8d7da; color: #721c24; }

    .priority-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-block;
    }

    .priority-high { background: #ff4d4d; color: white; }
    .priority-medium { background: #ffc107; color: white; }
    .priority-low { background: #28a745; color: white; }

    .description-box {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .actions {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
        gap: 1rem;
    }

    .back-link {
        text-decoration: none;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 1rem;
        display: inline-block;
    }
</style>
</head>
<body>

<div class="container">
    <a href="{{ route('admin.tasks.index') }}" class="back-link">← Back to Tasks</a>

    <div class="card">
        <div class="card-header">Task Details</div>
        <div class="card-body">
            <div class="info-row">
                <div class="info-item">
                    <div class="info-label">Task Title</div>
                    <div class="info-value">{{ $task->title }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Location</div>
                    <div class="info-value">{{ $task->location }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Priority</div>
                    <div class="info-value">
                        <span class="priority-badge priority-{{ $task->priority }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-item">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="status-badge status-{{ str_replace(' ', '_', $task->status) }}">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Scheduled Date</div>
                    <div class="info-value">{{ $task->scheduled_date->format('M d, Y') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Scheduled Time</div>
                    <div class="info-value">{{ $task->scheduled_time ?? 'Not specified' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Assigned To</div>
                    <div class="info-value">{{ $task->assignee?->name ?? 'Unassigned' }}</div>
                </div>
            </div>

            @if($task->description)
            <div style="margin-bottom: 1.5rem;">
                <div class="info-label" style="margin-bottom: 0.75rem;">Description</div>
                <div class="description-box">
                    {{ $task->description }}
                </div>
            </div>
            @endif

            @if($task->notes)
            <div style="margin-bottom: 1.5rem;">
                <div class="info-label" style="margin-bottom: 0.75rem;">Notes</div>
                <div class="description-box">
                    {{ $task->notes }}
                </div>
            </div>
            @endif

            <div class="info-row">
                <div class="info-item">
                    <div class="info-label">Created At</div>
                    <div class="info-value">{{ $task->created_at->format('M d, Y H:i') }}</div>
                </div>
                @if($task->completed_at)
                <div class="info-item">
                    <div class="info-label">Completed At</div>
                    <div class="info-value">{{ $task->completed_at->format('M d, Y H:i') }}</div>
                </div>
                @endif
            </div>

            <div class="actions">
                <a href="{{ route('admin.tasks.index') }}" class="btn btn-light">Back to Tasks</a>
                <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-edit">Edit Task</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
