<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    const ORDER_ACTIVE = 'ACTIVE';
    const ORDER_INACTIVE = 'INACTIVE';

    protected $fillable = [];
    
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    /*public function getTotalAttribute(){
        return $this->orderItems->sum(function(OrderItem $item){
            return $item->unit_price * $item->quantity;
        });
    }*/

    public function isActive(){
        return $this->status == Order::ORDER_ACTIVE;
    }
}
