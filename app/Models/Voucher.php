<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;


class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        "voucher_number",
        "sub_total",
        "total",
        "deli_fee",
        "actual_cost",
        "profit",
        "user_id",
        "promotion_amount",
        "pay_amount",
        "reduce_amount",
        "change",
        "debt_amount",
        "customer_name",
        "customer_phone",
        "customer_city",
        "customer_address",
        "is_kpay",
        "status",
    ];

    protected $casts = [
        "voucher_number" => "string",
        "sub_total" => "integer",
        "total" => "integer",
        "deli_fee" => "integer",
        "actual_cost" => "integer",
        "profit" => "integer",
        "user_id" => "string",
        "promotion_amount" => "integer",
        "pay_amount" => "integer",
        "reduce_amount" => "integer",
        "change" => "integer",
        "is_kpay" => "integer",
        "debt_amount"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voucherRecords()
    {
        return $this->hasMany(VoucherRecord::class);
    }

    public static function generateVoucherNumber()
    {
        $lastVoucher = DB::table('vouchers')->orderBy('id', 'desc')->first();

        // Start from 1 if no vouchers exist, otherwise increment the last voucher number
        $nextNumber = $lastVoucher ? intval($lastVoucher->voucher_number) + 1 : 1;

        // Format the number with leading zeros, making it a 6-digit string
        $voucherNumber = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        return $voucherNumber;
    }
}
