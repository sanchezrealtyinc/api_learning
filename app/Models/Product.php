<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Category;
use App\Models\Inventory;

class Product extends Model
{
    use HasFactory;

    /*
    Constantes para el manejo del estado (status)
    */
    const PRODUCT_ACTIVE = 'ACTIVE';
    const PRODUCT_INACTIVE = 'INACTIVE';

    /*
    Atributos que pueden ser asignados de manera masiva. 
    */
    protected $fillable = [
        'name',
        'description',
        'weight_class',
        'minimun_price',
        'price_currency',
        'category_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function inventory(){
        return $this->hasMany(Inventory::class);
    }

    public function isActive(){
        return $this->status == Product::PRODUCT_ACTIVE;
    }
}
