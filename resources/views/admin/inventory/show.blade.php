<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details</title>
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

    .status-in_stock { background: #d4edda; color: #155724; }
    .status-low_stock { background: #fff3cd; color: #856404; }
    .status-out_of_stock { background: #f8d7da; color: #721c24; }

    .cost-value {
        font-size: 1.25rem;
        color: var(--success);
        font-weight: 700;
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
    <a href="{{ route('admin.inventory.index') }}" class="back-link">← Back to Inventory</a>

    <div class="card">
        <div class="card-header">Item Details</div>
        <div class="card-body">
            <div class="info-row">
                <div class="info-item">
                    <div class="info-label">Item Name</div>
                    <div class="info-value">{{ $inventory->name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Category</div>
                    <div class="info-value">{{ ucfirst($inventory->category) }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="status-badge status-{{ str_replace(' ', '_', $inventory->status) }}">
                            {{ ucfirst(str_replace('_', ' ', $inventory->status)) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-item">
                    <div class="info-label">Current Quantity</div>
                    <div class="info-value">{{ $inventory->quantity }} {{ $inventory->unit }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Min Stock Level</div>
                    <div class="info-value">{{ $inventory->min_stock_level }} {{ $inventory->unit }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Total Cost</div>
                    <div class="cost-value">
                        @if($inventory->cost_per_unit)
                            ₱{{ number_format($inventory->quantity * $inventory->cost_per_unit, 2) }}
                        @else
                            N/A
                        @endif
                    </div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-item">
                    <div class="info-label">Cost Per Unit</div>
                    <div class="info-value">{{ $inventory->cost_per_unit ? '₱' . number_format($inventory->cost_per_unit, 2) : 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Supplier</div>
                    <div class="info-value">{{ $inventory->supplier ?? 'Not specified' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Location</div>
                    <div class="info-value">{{ $inventory->location ?? 'Not specified' }}</div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-item">
                    <div class="info-label">Last Updated</div>
                    <div class="info-value">{{ $inventory->updated_at->format('M d, Y H:i') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Created At</div>
                    <div class="info-value">{{ $inventory->created_at->format('M d, Y H:i') }}</div>
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('admin.inventory.index') }}" class="btn btn-light">Back to Inventory</a>
                <a href="{{ route('admin.inventory.edit', $inventory->id) }}" class="btn btn-edit">Edit Item</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
