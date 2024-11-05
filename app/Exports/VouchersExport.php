<?php

namespace App\Exports;

use App\Models\VoucherRecord;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class VouchersExport implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Return the collection of vouchers with selected fields.
     */
    public function collection()
    {
        return $this->data->map(function ($item) {
            $voucher_records = VoucherRecord::where(['voucher_id' => $item->id])->get();
            return [
                'voucher_number' => $item->voucher_number,
                'items' => $voucher_records->map(fn($voucher_record) => $voucher_record->product->name)->join(', '),
                'total' => $item->total,
                'customer_name' => $item->customer_name,
                'customer_phone' => $item->customer_phone,
                'customer_city' => $item->customer_city,
                'customer_address' => $item->customer_address,
                'payment_method' => $item->payment_method,
                'order_date' => $this->formatOrderDate($item->order_date),
            ];
        });
    }


    /**
     * Define the headings for the Excel file.
     */
    public function headings(): array
    {
        return [
            'ဘောင်ချာနံပါတ်',
            'ပစ္စည်းများ',
            'စုစုပေါင်း',
            'အမည်',
            'ဖုန်းနံပါတ်',
            'မြို့',
            'လိပ်စာ',
            'ငွေပေးချေမှုနည်းလမ်း',
            'မှာယူသည့်ရက်စွဲ',
        ];
    }

    private function formatOrderDate($orderDate)
    {
        return Carbon::parse($orderDate)->format('d M Y');  // Converts to '15 Oct 2024' format
    }
}
