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

        $order->customer_name = $request->customer_name ?? $order->customer_name;
        $order->customer_phone = $request->customer_phone ?? $order->customer_phone;
        $order->customer_city = $request->customer_city ?? $order->customer_city;
        $order->customer_address = $request->customer_address ?? $order->customer_address;
        $order->payment_method = $request->payment_method ?? $order->payment_method;
        $order->status = $request->status ?? $order->status;
        $order->deli_fee = $request->deli_fee ?? $order->deli_fee;
        $order->remark = $request->remark ?? $order->remark;
        $order->order_date = $request->order_date ?? $order->order_date;

        $total_cost = 0;
        $total_actual_cost = 0;
        $total_profit = 0;
        $total_quantity = 0;

        // Get all existing voucher records for this order
        $existingVoucherRecords = VoucherRecord::where('voucher_id', $order->id)->get();

        // Keep track of the IDs of the voucher records that are still in the request
        $updatedVoucherRecordIds = [];

        foreach ($request['orders'] as $req_order) {
            $product = Product::find($req_order['product']['id']);
            $cost = $req_order['quantity'] * $product->primary_price;
            $actual_cost = $req_order["quantity"] * $product->actual_price;

            $new_stock = $product->stock - $req_order["quantity"];

            if ($req_order['id']) {
                // Update existing voucher record
                $voucher_record = VoucherRecord::find($req_order['id']);

                $voucher_record->quantity = $req_order['quantity'];
                $voucher_record->cost = $cost;

                $voucher_record->save();

                // Add the ID to the list of updated records
                $updatedVoucherRecordIds[] = $voucher_record->id;
            } else {
                // Create a new voucher record
                $voucher_record = VoucherRecord::create([
                    "unit_id" => $product->primary_unit_id,
                    "product_id" => $product->id,
                    "quantity" => $req_order['quantity'],
                    "cost" => $cost,
                    "voucher_id" => $order->id
                ]);

                // Add the ID to the list of updated records
                $updatedVoucherRecordIds[] = $voucher_record->id;
            }

            $total_cost += $cost;
            $total_actual_cost += $actual_cost;
            $total_profit += $cost - $actual_cost;

            $product->stock = $new_stock;
            $product->save();
        }

        // Delete voucher records that are no longer in the request
        foreach ($existingVoucherRecords as $existingVoucherRecord) {
            if (!in_array($existingVoucherRecord->id, $updatedVoucherRecordIds)) {
                $existingVoucherRecord->delete();
            }
        }

        $order->sub_total = $total_cost;
        $order->total = $total_cost + $request->deli_fee;
        $order->profit = $total_profit;
        $order->actual_cost = $total_actual_cost ?? 0;

        $order->save();

        return response()->json(["message" => "အောင်မြင်ပါသည်", "data" => $order]);
    }
}
