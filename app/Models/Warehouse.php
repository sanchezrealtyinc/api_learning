<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Location;

class Warehouse extends Model
{
    use HasFactory;

    const WAREHOUSE_ACTIVE = 'ACTIVE';
    const WAREHOUSE_INACTIVE = 'INACTIVE';

    protected $fillable = [];

    public function locations(){
        return $this->belongsTo(Location::class);
    }

    public function isActive(){
        return $this->status == Warehouse::WAREHOUSE_ACTIVE;
    }
}
