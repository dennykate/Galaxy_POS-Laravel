<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Mockery\Undefined;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "phone",
        "birth_date",
        "join_date",
        "gender",
        "address",
        "password",
        "role",
        "position",
        "salary",
        "profile"
    ];

    protected $casts = [
        "name" => "string",
        "phone" => "string",
        "birth_date" => "timestamp",
        "join_date" => "timestamp",
        "gender" => "string",
        "address" => "string",
        "password" => "string",
        "role" => "string",
        "position" => "string",
        "salary" => "integer",
        "profile" => "string",
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */


    public function salaries()
    {
        return $this->hasMany(PaySalary::class);
    }

    public function deli()
    {
        return $this->hasOne(DeliWay::class);
    }
}
