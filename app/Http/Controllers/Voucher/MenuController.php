<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $orderDate = $request->input('order_date'); // Get the order date from the request

        $vouchers = Voucher::with(['voucherRecords' => function ($query) {
            $query->with('product:id,name,image,actual_price,primary_price,stock'); // Only select product details
        }])
            ->when($orderDate, function ($query, $orderDate) {
                return $query->where('order_date', $orderDate);
            })
            ->get()
            ->map(function ($voucher) {
                $voucher['products'] = $voucher->voucherRecords->pluck('product')->unique();
                return $voucher;
            });

        return response()->json(['data' => $vouchers]);
    }
}
