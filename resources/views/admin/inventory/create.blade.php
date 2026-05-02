<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Inventory Item</title>
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
    <a href="{{ route('admin.inventory.index') }}" class="btn btn-light">← Back to Inventory</a>

    <div class="card">
        <div class="card-header">Add New Item</div>
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

            <form action="{{ route('admin.inventory.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div>
                        <label class="form-label">Item Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category') }}" required>
                        @error('category')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div>
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 0) }}" min="0" required>
                        @error('quantity')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label">Unit</label>
                        <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror" value="{{ old('unit') }}" placeholder="e.g., pcs, kg, liters" required>
                        @error('unit')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div>
                        <label class="form-label">Min Stock Level</label>
                        <input type="number" name="min_stock_level" class="form-control @error('min_stock_level') is-invalid @enderror" value="{{ old('min_stock_level', 5) }}" min="0" required>
                        @error('min_stock_level')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label">Cost Per Unit</label>
                        <input type="number" name="cost_per_unit" class="form-control @error('cost_per_unit') is-invalid @enderror" value="{{ old('cost_per_unit') }}" min="0" step="0.01">
                        @error('cost_per_unit')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div>
                        <label class="form-label">Supplier</label>
                        <input type="text" name="supplier" class="form-control @error('supplier') is-invalid @enderror" value="{{ old('supplier') }}">
                        @error('supplier')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}">
                        @error('location')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                    <a href="{{ route('admin.inventory.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Add Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
