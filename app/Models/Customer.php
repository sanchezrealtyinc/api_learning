<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Person;

class Customer extends Model
{
    use HasFactory;

    const CUSTOMER_ACTIVE = 'ACTIVE';
    const CUSTOMER_INACTIVE = 'INACTIVE';

    protected $fillable = [
        'company_name',
        'job_title',
        'departament',
        'limit_credit'
    ];

    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function isActive(){
        return $this->status == Customer::CUSTOMER_ACTIVE;
    }
}
