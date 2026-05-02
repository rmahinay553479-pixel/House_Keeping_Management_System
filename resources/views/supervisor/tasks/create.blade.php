<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task - Supervisor</title>
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
            max-width: 900px;
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

        .form-label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d3e2;
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background-color: #fff;
            margin-bottom: 1rem;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: #4a4a4a;
            box-shadow: 0 0 0 3px rgba(74, 74, 74, 0.15);
        }

        .row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .alert {
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            border: 1px solid;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background-color: #4a4a4a;
            color: white;
        }

        .btn-primary:hover {
            background-color: #333333;
            transform: translateY(-2px);
        }

        .error-message {
            color: #e74a3b;
            font-size: 0.8rem;
            margin-top: -0.8rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .role-badge {
            display: inline-block;
            background: linear-gradient(135deg, #333333 0%, #555555 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        h1 {
            color: #222222;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 0;
        }

        .alert ul {
            margin: 0.5rem 0 0 1.25rem;
        }

        .alert li {
            margin-bottom: 0.25rem;
        }

        @media (max-width: 768px) {
            .row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <a href="/supervisor/dashboard" class="btn-light">← Back to Dashboard</a>

    <div class="card">
        <div class="card-header">
            <div class="role-badge">SUPERVISOR</div>
            <h1>Create New Task</h1>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Validation Errors!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div style="padding: 1rem 1.25rem; margin-bottom: 1.5rem; border-radius: 8px; background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('supervisor.tasks.store') }}" method="POST">
                @csrf

                <div>
                    <label class="form-label">Task Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Enter task title" required>
                    @error('title')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Enter task description" required>{{ old('description') }}</textarea>
                    @error('description')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div>
                        <label class="form-label">Assign To Housekeeper</label>
                        <select name="assigned_to" class="form-select @error('assigned_to') is-invalid @enderror" required>
                            <option value="">-- Select Housekeeper --</option>
                            @foreach($housekeepers as $housekeeper)
                                <option value="{{ $housekeeper->id }}" {{ old('assigned_to') == $housekeeper->id ? 'selected' : '' }}>
                                    {{ $housekeeper->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('assigned_to')<div class="error-message">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select @error('priority') is-invalid @enderror" required>
                            <option value="">-- Select Priority --</option>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div>
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date') }}" required>
                        @error('due_date')<div class="error-message">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="form-label">Location (Optional)</label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" placeholder="e.g., Floor 2, Room 101">
                        @error('location')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                    <a href="/supervisor/dashboard" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
