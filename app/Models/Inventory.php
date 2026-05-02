<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'name',
        'category',
        'quantity',
        'unit',
        'min_stock_level',
        'cost_per_unit',
        'supplier',
        'location',
        'status',
    ];

    public function isLowStock(): bool
    {
        return $this->quantity <= $this->min_stock_level;
    }
}
