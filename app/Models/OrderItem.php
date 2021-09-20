<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Order;

class OrderItem extends Model
{
    use HasFactory;

    const ORDER_ITEM_ACTIVE = 'ACTIVE';
    const ORDER_ITEM_INACTIVE = 'INACTIVE';

    protected $fillable = [];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function isActive(){
        return $this->status == OrderItem::ORDER_ITEM_ACTIVE;
    }
}
