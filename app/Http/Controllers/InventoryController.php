<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $inventory = $query->latest()->paginate(15);
        $categories = Inventory::distinct()->pluck('category');

        return view('admin.inventory.index', compact('inventory', 'categories'));
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'min_stock_level' => 'required|integer|min:0',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $validated['status'] = $this->determineStockStatus($validated['quantity'], $validated['min_stock_level']);

        Inventory::create($validated);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Item added to inventory.');
    }

    public function show(Inventory $inventory)
    {
        return view('admin.inventory.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        return view('admin.inventory.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'min_stock_level' => 'required|integer|min:0',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $validated['status'] = $this->determineStockStatus($validated['quantity'], $validated['min_stock_level']);

        $inventory->update($validated);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Item removed from inventory.');
    }

    private function determineStockStatus(int $quantity, int $minLevel): string
    {
        if ($quantity === 0) {
            return 'out_of_stock';
        }
        if ($quantity <= $minLevel) {
            return 'low_stock';
        }
        return 'in_stock';
    }
}
