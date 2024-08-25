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
            "customer_name" => $this->customer_name,
            "customer_phone" => $this->customer_phone,
            "customer_city" => $this->customer_city,
            "customer_address" => $this->customer_address,
            "is_kpay" => $this->is_kpay,
            "status" => $this->status,
            "remark" => $this->remark,
            "voucher_records" => VoucherRecordResource::collection($this->voucherRecords),

        ];
    }
}
