<?php

namespace App\Http\Resources\Voucher;

use App\Http\Controllers\HelperController;
use App\Http\Resources\Cashier\CashierItemUnitResource;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $productUnits = array_map(function ($item) {
            $item['name'] = Unit::find($item['unit_id'])->name;

            return $item;
        }, $this->product->productUnits->toArray());

        return [
            "id" => $this->id,
            "product" => [
                ...$this->product->toArray(),
                'units' => [
                    [
                        "price" => $this->product->primary_price,
                        "unit_id" => $this->product->primary_unit_id,
                        "name" => $this->product->unit->name,
                        "id" => encrypt($this->id)
                    ],
                    ...CashierItemUnitResource::collection($this->product->productUnits)->resolve() // Convert to array
                ]
            ],
            "image" => HelperController::parseReturnImage($this->product->image),
            "name" => $this->product->name,
            "unit" => $this->unit->name,
            "unit_id" => $this->unit->id,
            // "unit_info" => $this->unit,
            "quantity" => $this->quantity,
            "cost" => $this->cost,
            "primary_unit_id" => $this->product->primary_unit_id,
            "primary_price" => $this->product->primary_price,
            "stock" => $this->product->stock,
            "categories" => $this->product->categories,
            "units" => [
                ["price" => $this->product->primary_price, "unit_id" =>  $this->product->primary_unit_id, "name" => $this->product->unit->name, "id" => $this->id],
                ...$productUnits
            ],
            "promotion" => $this->promotion,
        ];
    }
}
