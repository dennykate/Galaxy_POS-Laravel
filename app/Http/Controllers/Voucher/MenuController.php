<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\VoucherRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $startDate = Carbon::createFromFormat('d-m-Y', $request->input('start_date'))->startOfDay();
        $endDate = Carbon::createFromFormat('d-m-Y', $request->input('end_date'))->endOfDay();

        // Get the list of products grouped by summing their quantity
        $products = VoucherRecord::select('product_id')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->whereHas('voucher', function ($query) use ($startDate, $endDate) {
                $query->whereNot('status', 'ရှင်းပြီး');
                $query->whereBetween('order_date', [$startDate, $endDate]);
            })

            ->groupBy('product_id')
            ->with('product:id,name,image,actual_price,primary_price')
            ->get()
            ->map(function ($data) {
                $data['product']['quantity'] = intval($data['total_quantity']);

                return $data['product'];
            });

        // Get the list grouped by customer_city and count it
        $cities = Voucher::select('customer_city as city')
            ->whereNot('status', 'ရှင်းပြီး')
            ->selectRaw('COUNT(*) as total')
            ->whereBetween('order_date', [$startDate, $endDate])
            ->groupBy('customer_city')
            ->get();

        return response()->json([
            "data" => [
                'products' => $products,
                'cities' => $cities,
            ]
        ]);
    }
}
