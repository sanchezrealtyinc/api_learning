<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    const CATEGORY_ACTIVE = 'ACTIVE';
    const CATEGORY_INACTIVE = 'INACTIVE';

    protected $fillable = [
        'name',
        'description'
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function isActive(){
        return $this->status == Category::CATEGORY_ACTIVE;
    }
}
