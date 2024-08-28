<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
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

        $order->save();

        return response()->json(['data' => $order]);
    }
}
