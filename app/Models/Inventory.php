<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Models\Warehouse;

class Inventory extends Model
{
    use HasFactory;

    const INVENTORY_ACTIVE = 'ACTIVE';
    const INVENTORY_INACTIVE = 'INACTIVE';

    protected $fillable = [];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }

    public function isActive(){
        return $this->status == Inventory::INVENTORY_ACTIVE;
    }
}
