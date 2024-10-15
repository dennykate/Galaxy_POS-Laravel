<?php

namespace App\Http\Services\Delivery;

use App\Models\DeliWay;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VouchersExport;

class DeliWayExcelService
{
    public static function execute(Request $request)
    {
        $deli = DeliWay::where('user_id', $request->query('deli_man'))->first();
        $query = Voucher::query();

        if (!$deli) {
            return response()->json(['message' => 'No delivery person found'], 404);
        }

        // Search filter
        if ($request->filled('search')) {
            $query->where(function (Builder $builder) use ($request) {
                foreach (['customer_name'] as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $builder->{$method}($column, 'like', '%' . $request->search . '%');
                }
            });
        }

        // Cities filter
        if (!empty($deli->cities)) {
            $query->where(function (Builder $builder) use ($deli) {
                $cities = array_filter(array_map('trim', explode(',', $deli->cities)));

                if (empty($cities)) {
                    return response()->json(['message' => 'No valid cities provided'], 400);
                }

                $builder->whereIn('customer_city', $cities);
            });
        } else {
            return response()->json(['message' => 'No cities provided'], 400);
        }

        // Date range filter
        if ($request->filled(['start_date', 'end_date'])) {
            $filter_date = $request->query('filter_date', 'created_at');

            $query->whereBetween($filter_date, [
                $request->start_date,
                Carbon::parse($request->end_date)->addDay(),
            ]);
        }

        // Custom filters
        if ($request->filled('filters')) {
            $filters = explode('_', $request->filters);
            $query->where($filters[0], $filters[1]);
        }

        // Filter parameter
        if ($request->filled('filter')) {
            foreach ($request->filter as $key => $value) {
                $query->where($key, 'like', '%' . $value . '%');
            }
        }

        // Get all the results without pagination
        $data = $query->get();

        // Export to Excel and download
        return Excel::download(new VouchersExport($data), 'vouchers.xlsx');
    }
}
