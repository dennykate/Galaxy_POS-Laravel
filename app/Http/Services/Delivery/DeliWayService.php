<?php

namespace App\Http\Services\Delivery;

use App\Http\Resources\VouchersResource;
use App\Models\DeliWay;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DeliWayService
{
    public static function deliWay(Request $request)
    {
        $deli = DeliWay::where('user_id', $request->query('deli_man'))->first();
        $query =  Voucher::query();

        if (!$deli)  return VouchersResource::collection([]);

        // Search filter
        if ($request->filled('search')) {
            $query->where(function (Builder $builder) use ($request) {
                foreach (['customer_name'] as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $builder->{$method}($column, 'like', '%' . $request->search . '%');
                }
            });
        }


        if (!empty($deli->cities)) {
            $query->where(function (Builder $builder) use ($deli) {
                // Convert the cities string to an array and remove empty values
                $cities = array_filter(array_map('trim', explode(',', $deli->cities)));

                if (empty($cities)) {
                    // Return an empty collection if no valid cities are provided
                    return VouchersResource::collection([]);
                }

                logger($cities); // Log the cities for debugging

                // Apply the filter using whereIn if there are valid cities
                $builder->whereIn('customer_city', $cities);
            });
        } else {
            // Return an empty collection if no cities are provided
            return VouchersResource::collection([]);
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

        $rOrderBy = $request->query("sort_by", "id");
        $rOrderDirection = $request->query("sort_type", "desc");

        // Ordering and pagination
        $data = $query->orderBy($rOrderBy, $rOrderDirection)
            ->paginate($request->input('limit', 20))
            ->withQueryString();

        return VouchersResource::collection($data);
    }
}
