<?php

namespace App\Http\Resources\Voucher;

use App\Http\Controllers\HelperController;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "staff" => $this->user->name,
            "voucher_no" => $this->voucher_number,
            "time" => HelperController::parseReturnDate($this->created_at, true),
            "sub_total" => $this->sub_total,
            "total" => $this->total,
            "deli_fee" => $this->deli_fee,
            "pay_amount" => $this->pay_amount,
            "actual_cost" => $this->actual_cost,
            "reduce_amount" => $this->reduce_amount,
            "profit" => $this->profit,
            "change" => $this->change,
            "debt_amount" => $this->debt_amount,
            "promotion_amount" => $this->promotion_amount,
            "customer_name" => $this->customer_name,
            "customer_phone" => $this->customer_phone,
            "customer_city" => $this->customer_city,
            "customer_address" => $this->customer_address,
            "payment_method" => $this->payment_method,
            "status" => $this->status,
            "remark" => $this->remark,
            "voucher_records" => VoucherRecordResource::collection($this->voucherRecords),

        ];
    }
}
