<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


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
        "payment_method",
        "status",
        'remark',
        'order_date'
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
        "payment_method" => "string",
        "debt_amount"
    ];

    protected $dates = ['order_date'];

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

    public function setOrderDateAttribute($value)
    {
        $this->attributes['order_date'] = Carbon::createFromFormat('d-m-Y', $value);
    }

    // Getter for order_date
    public function getOrderDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
