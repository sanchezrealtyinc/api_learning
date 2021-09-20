<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Person;

class Employment extends Model
{
    use HasFactory;

    const EMPLOYMENT_ACTIVE = 'ACTIVE';
    const EMPLOYMENT_INACTIVE = 'INACTIVE';

    protected $fillable = [
        'work_position',
        'job_title',
        'salary'
    ];

    public function person(){
        return $this->belongsTo(Person::class);
    }
    
    public function isActive(){
        return $this->status == Employment::EMPLOYMENT_ACTIVE;
    }
}
