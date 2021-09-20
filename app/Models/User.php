<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Person;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const USER_ACTIVE = 'ACTIVE';
    const USER_INACTIVE = 'INACTIVE';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guarded = [];

    public function scopeRegularUser($query){
        return $query->where('is_admin', 0);
    }

    public function scopeAdmins($query){
        return $query->where('is_admin', 1);
    }

    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function isActive(){
        return $this->status == USER::USER_ACTIVE;
    }
}
