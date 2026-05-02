<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            color: #4e73df;
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
            margin-top: 0.5rem;
            margin-bottom: 1rem;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: #4e73df;
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
            background-color: #fff;
        }

        .form-control::placeholder {
            color: #aaa;
        }

        .form-select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%234e73df' d='M0 0l6 8 6-8z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }

        .row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .error-message {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: -0.8rem;
            margin-bottom: 0.5rem;
            display: block;
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

        .alert ul {
            margin: 0.5rem 0 0 1.25rem;
            padding-left: 0;
        }

        .alert li {
            margin-bottom: 0.25rem;
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
            background-color: #4e73df;
            color: white;
        }

        .btn-primary:hover {
            background-color: #224abe;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
        }

        .btn-light {
            background-color: #f8f9fc;
            color: #333;
            border: 1px solid #ddd;
        }

        .btn-light:hover {
            background-color: #e8e8e8;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .row {
                grid-template-columns: 1fr;
            }

            .card-body {
                padding: 1.5rem;
            }

            body {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <a href="{{ route('admin.users.index') }}" class="btn btn-light">← Back to Users</a>

    <div class="card">
        <div class="card-header">Create New User</div>
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

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div>
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div>
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required>
                        @error('password_confirmation')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div>
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="">-- Select Role --</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                            <option value="housekeeper" {{ old('role') == 'housekeeper' ? 'selected' : '' }}>Housekeeper</option>
                        </select>
                        @error('role')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="">-- Select Status --</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div>
                    <label class="form-label">Phone (Optional)</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                    @error('phone')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
