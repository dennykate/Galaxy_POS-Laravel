<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HelperController;
use App\Http\Resources\Voucher\VoucherDetailResource;
use App\Http\Resources\VouchersResource;
use App\Models\ConversionFactor;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Gate::allows("checkPermission", "manager,deli")) return response()->json(["message" => "လုပ်ပိုင်ခွင့်မရှိပါ"], 403);
        $vouchers = HelperController::findAllQuery(new Voucher, $request, [
            "customer_name"
        ]);

        return VouchersResource::collection($vouchers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!Gate::allows("checkPermission", "manager")) return response()->json(["message" => "လုပ်ပိုင်ခွင့်မရှိပါ"], 403);
        $voucher = Voucher::find(decrypt($id));
        if (is_null($voucher)) {
            return response()->json(["message" => "ဘောက်ချာမရှိပါ"], 400);
        }

        return new VoucherDetailResource($voucher);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $voucher = Voucher::with('voucherRecords.product')->find(decrypt($id));

            if (!$voucher) {
                return response()->json(["message" => "ဘောက်ချာမရှိပါ"], 400);
            }

            // Process each voucher record to restore stock
            foreach ($voucher->voucherRecords as $record) {
                $product = $record->product;

                if ($record->unit_id == $product->primary_unit_id) {
                    // If units are same, directly add quantity
                    $product->stock += $record->quantity;
                } else {
                    // If units are different, need to convert
                    $conversionFactor = ConversionFactor::where(function ($query) use ($record, $product) {
                        $query->where('from_unit_id', $record->unit_id)
                            ->where('to_unit_id', $product->primary_unit_id);
                    })->orWhere(function ($query) use ($record, $product) {
                        $query->where('from_unit_id', $product->primary_unit_id)
                            ->where('to_unit_id', $record->unit_id);
                    })->first();

                    if ($conversionFactor) {
                        if ($conversionFactor->from_unit_id == $record->unit_id) {
                            // Convert from record unit to primary unit
                            $convertedQuantity = $record->quantity * $conversionFactor->value;
                        } else {
                            // Convert from primary unit to record unit
                            $convertedQuantity = $record->quantity / $conversionFactor->value;
                        }

                        $product->stock += $convertedQuantity;
                    } else {
                        throw new \Exception("Conversion factor not found for units");
                    }
                }

                $product->save();
            }

            $voucher->delete(); // This will cascade delete voucher_records due to foreign key constraint

            DB::commit();

            return response()->json(["message" => "ဘောက်ချာဖျက်ခြင်း အောင်မြင်ပါသည်"]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => "Error: " . $e->getMessage()], 500);
        }
    }
}
