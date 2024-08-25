<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = ['place', 'cost', 'item_quantity', 'remark', 'user_id', 'status'];

    protected $casts = [
        'place' => "string",
        'cost' => "integer",
        'item_quantity' => "integer",
        'remark' => "string",
        'user_id' => "string",
        'status' => "string"
    ];

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function purchaseRecords()
    {
        return $this->hasMany(PurchaseRecords::class);
    }
}
