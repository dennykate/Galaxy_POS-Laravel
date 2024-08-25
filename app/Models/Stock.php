<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ["quantity", "cost", "unit_id", "product_id", "user_id"];

    protected $casts = [
        "quantity" => "double",
        "cost" => "integer",
        "unit_id" => "string",
        "product_id" => "string",
        "user_id" => "string"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
