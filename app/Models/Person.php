<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Employment;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\User;

class Person extends Model
{
    use HasFactory;

    const PERSON_ACTIVE = 'ACTIVE';
    const PERSON_INACTIVE = 'INACTIVE';

    /*Campos que puede ser llenados con asignación masiva (Factory - Seeders)*/
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'phone_number',
        'birthday'
    ];

    /*Campos que no pueden ser llenados con asignación masiva (Mass Assignment) Example:ID*/
    protected $guarded = [];
    
    public function getFullName(){
        return $this->first_name . ' ' . $this->last_name;
    }

    public function user(){
        return $this->hasOne(User::class);
    }

    public function employment(){
        return $this->hasOne(Employment::class);
    }

    public function customer(){
        return $this->hasOne(Customer::class);
    }

    public function supplier(){
        return $this->hasOne(Supplier::class);
    }

    public function isActive(){
        return $this->status == Person::PERSON_ACTIVE;
    }
}
