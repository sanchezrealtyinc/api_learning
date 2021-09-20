<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Warehouse;

class Location extends Model
{
    use HasFactory;

    const LOCATION_ACTIVE = 'ACTIVE';
    const LOCATION_INACTIVE = 'INACTIVE';

    protected $fillable = [];
    protected $guarded = [];

    public function warehouses(){
        return $this->hasMany(Warehouse::class);
    }

    public function isActive(){
        return $this->status == Location::LOCATION_ACTIVE;
    }
}
