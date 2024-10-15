<?php

namespace App\Exports;

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
            return [
                'voucher_number' => $item->voucher_number,
                'order_date' => $this->formatOrderDate($item->order_date),
                'total' => $item->total,
                'sub_total' => $item->sub_total,
                'deli_fee' => $item->deli_fee,
                'customer_name' => $item->customer_name,
                'customer_phone' =>  " $item->customer_phone",
                'customer_city' => $item->customer_city,
                'customer_address' => $item->customer_address,
                'payment_method' => $item->payment_method,
            ];
        });
    }


    /**
     * Define the headings for the Excel file.
     */
    public function headings(): array
    {
        return [
            'Voucher Number',
            'Order Date',
            'Total',
            'Sub Total',
            'Delivery Fee',
            'Name',
            'Phone',
            'City',
            'Address',
            'Payment Method',
        ];
    }

    private function formatOrderDate($orderDate)
    {
        return Carbon::parse($orderDate)->format('d M Y');  // Converts to '15 Oct 2024' format
    }
}
