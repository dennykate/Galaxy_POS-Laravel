<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Controllers\Controller;
use App\Models\ConversionFactor;
use App\Models\Voucher;
use App\Models\VoucherRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Integer;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $startDate = Carbon::createFromFormat('d-m-Y', $request->input('start_date'))->startOfDay();
        $endDate = Carbon::createFromFormat('d-m-Y', $request->input('end_date'))->endOfDay();

        // Get the list of products with unit conversion
        $products = VoucherRecord::select(
            'product_id',
            'unit_id',
            DB::raw('SUM(quantity) as total_quantity')
        )
            ->whereHas('voucher', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('order_date', [$startDate, $endDate]);
            })
            ->groupBy('product_id', 'unit_id')
            ->with([
                'product:id,name,image,actual_price,primary_price,primary_unit_id',
                'unit:id',
                'product.primaryUnit:id'
            ])
            ->get()
            ->groupBy('product_id')
            ->map(function ($records) {
                $product = $records->first()->product;
                $totalQuantityInPrimaryUnit = 0;

                foreach ($records as $record) {
                    $quantity = $record->total_quantity;

                    // If unit is different from primary unit, convert it
                    if ($record->unit_id !== $product->primary_unit_id) {
                        // First try direct conversion
                        $conversion = ConversionFactor::where([
                            'from_unit_id' => $record->unit_id,
                            'to_unit_id' => $product->primary_unit_id
                        ])->first();

                        if ($conversion) {
                            $quantity *= $conversion->value;
                        } else {
                            // Try reverse conversion
                            $reverseConversion = ConversionFactor::where([
                                'from_unit_id' => $product->primary_unit_id,
                                'to_unit_id' => $record->unit_id
                            ])->first();

                            if ($reverseConversion) {
                                $quantity /= $reverseConversion->value;
                            }
                            // If no conversion found, quantity remains unchanged
                            // You might want to log this case or handle it differently
                        }
                    }

                    $totalQuantityInPrimaryUnit += $quantity;
                }

                $product->quantity = $totalQuantityInPrimaryUnit;
                return $product;
            });

        // Get the list grouped by customer_city and count it
        $cities = Voucher::select('customer_city as city')
            ->selectRaw('COUNT(*) as total')
            ->whereBetween('order_date', [$startDate, $endDate])
            ->groupBy('customer_city')
            ->get();

        return response()->json([
            "data" => [
                'products' => $products->values(), // Convert collection to array
                'cities' => $cities,
            ]
        ]);
    }
}
