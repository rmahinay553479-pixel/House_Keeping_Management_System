<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
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

    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px;
        border: 1px solid #d1d3e2;
        width: 100%;
        margin-top: 0.5rem;
        margin-bottom: 1rem;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        outline: none;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #333;
    }

    .row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .error-message {
        color: var(--danger);
        font-size: 0.875rem;
        margin-top: -0.75rem;
        margin-bottom: 0.5rem;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>
</head>
<body>

<div class="container">
    <a href="{{ route('admin.tasks.index') }}" class="btn btn-light">← Back to Tasks</a>

    <div class="card">
        <div class="card-header">Edit Task</div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Validation Errors!</strong>
                    <ul style="margin: 0.5rem 0 0 1.25rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div>
                        <label class="form-label">Task Title</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $task->title) }}" required>
                        @error('title')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $task->location) }}" required>
                        @error('location')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div>
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $task->description) }}</textarea>
                    @error('description')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div>
                        <label class="form-label">Scheduled Date</label>
                        <input type="date" name="scheduled_date" class="form-control @error('scheduled_date') is-invalid @enderror" value="{{ old('scheduled_date', $task->scheduled_date->format('Y-m-d')) }}" required>
                        @error('scheduled_date')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label">Scheduled Time</label>
                        <input type="time" name="scheduled_time" class="form-control @error('scheduled_time') is-invalid @enderror" value="{{ old('scheduled_time', $task->scheduled_time) }}">
                        @error('scheduled_time')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div>
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select @error('priority') is-invalid @enderror" required>
                            <option value="">-- Select Priority --</option>
                            <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="">-- Select Status --</option>
                            <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $task->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div>
                    <label class="form-label">Assign To</label>
                    <select name="assigned_to" class="form-select @error('assigned_to') is-invalid @enderror">
                        <option value="">-- Unassigned --</option>
                        @foreach($cleaners as $cleaner)
                            <option value="{{ $cleaner->id }}" {{ old('assigned_to', $task->assigned_to) == $cleaner->id ? 'selected' : '' }}>
                                {{ $cleaner->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_to')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $task->notes) }}</textarea>
                    @error('notes')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                    <a href="{{ route('admin.tasks.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
