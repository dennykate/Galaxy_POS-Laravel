<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\VoucherRecord;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EditCheckoutController extends Controller
{
    public static function execute(Request $request, string $id)
    {
        $order = Voucher::find(decrypt($id));

        if (!$order) throw new NotFoundHttpException('Order not found');

        // Update order details
        $order->customer_name = $request->customer_name ?? $order->customer_name;
        $order->customer_phone = $request->customer_phone ?? $order->customer_phone;
        $order->customer_city = $request->customer_city ?? $order->customer_city;
        $order->customer_address = $request->customer_address ?? $order->customer_address;
        $order->payment_method = $request->payment_method ?? $order->payment_method;
        $order->status = $request->status ?? $order->status;
        $order->deli_fee = $request->deli_fee ?? $order->deli_fee;
        $order->remark = $request->remark ?? $order->remark;
        $order->order_date = $request->order_date ?? $order->order_date;

        // Initialize totals
        $total_cost = 0;
        $total_actual_cost = 0;
        $total_profit = 0;

        if ($request->shouldUpdateOrder) {
            // Delete all existing voucher records for this order
            VoucherRecord::where('voucher_id', $order->id)->delete();

            // Process each order item
            foreach ($request['orders'] as $req_order) {
                // Calculate costs based on the product data from request
                $quantity = $req_order['quantity'];
                $primary_price = $req_order['product']['primary_price'];
                $actual_price = $req_order['product']['actual_price'];

                $cost = $quantity * $primary_price;
                $actual_cost = $quantity * $actual_price;

                // Create new voucher record
                VoucherRecord::create([
                    "unit_id" => $req_order['product']['primary_unit_id'],
                    "product_id" => $req_order['product']['id'],
                    "quantity" => $quantity,
                    "cost" => $cost,
                    "voucher_id" => $order->id
                ]);

                // Update product stock
                $product = Product::find($req_order['product']['id']);
                $product->decrement('stock', $quantity);

                // Update running totals
                $total_cost += $cost;
                $total_actual_cost += $actual_cost;
                $total_profit += $cost - $actual_cost;
            }
        }

        // Update order totals
        $order->sub_total = $total_cost;
        $order->total = $total_cost + ($order->deli_fee ?? 0);
        $order->profit = $total_profit;
        $order->actual_cost = $total_actual_cost;

        $order->save();

        return response()->json([
            "message" => "အောင်မြင်ပါသည်",
            "version" => "1.0.1",
            "data" => $order
        ]);
    }
}
