<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    const SUPPLIER_ACTIVE = 'ACTIVE';
    const SUPPLIER_INACTIVE = 'INACTIVE';

   protected $fillable = [
       'company_name',
       'phone_number'
   ];

    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function isActive(){
        return $this->status == Supplier::SUPPLIER_ACTIVE;
    }

}
