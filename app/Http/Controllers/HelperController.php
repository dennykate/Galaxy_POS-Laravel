<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HelperController extends Controller
{
    // $additionalConditions = [
    //     ['status', '=', 'active'],
    //     ['category', '!=', 'archived'],
    // ];

    // $orderBy = $request->input('order_by', 'id'); 
    // $orderDirection = $request->input('order_direction', 'desc'); 

    public static function findAllQuery(Model $model, Request $request, array $searchableColumns, array $additionalConditions = [], string $orderBy = 'id', string $orderDirection = 'desc', string $trashedOption = 'without')
    {
        // Initialize query with soft delete handling
        $trashedOption = $request->query("restore_type", "without");

        switch ($trashedOption) {
            case 'only':
                $query = $model::onlyTrashed(); // Only trashed records
                break;
            case 'with':
                $query = $model::withTrashed(); // Both trashed and non-trashed
                break;
            default:
                $query = $model::query(); // Default, non-trashed
                break;
        }

        $rOrderBy = $request->query("sort_by", "id");
        $rOrderDirection = $request->query("sort_type", "desc");

        // Search filter
        if ($request->filled('search')) {
            $query->where(function (Builder $builder) use ($searchableColumns, $request) {
                foreach ($searchableColumns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $builder->{$method}($column, 'like', '%' . $request->search . '%');
                }
            });
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

        // Additional conditions
        foreach ($additionalConditions as $condition) {
            $query->where($condition[0], $condition[1], $condition[2]);
        }

        // Ordering and pagination
        return $query->orderBy($rOrderBy, $rOrderDirection)
            ->paginate($request->input('limit', 20))
            ->withQueryString();
    }

    static function handleLogoUpload($file, $currentLogo)
    {
        if ($file) {
            // Delete the current logo if it exists
            if ($currentLogo) {
                Storage::disk('public')->delete($currentLogo);
            }

            // Upload the new logo
            $path = $file->store('images', 'public');

            return $path;
        }

        // If no new logo is provided, keep the current one
        return $currentLogo;
    }

    static function transaction(callable $callback)
    {
        try {
            // Start a database transaction
            DB::beginTransaction();

            // Call the provided callback function
            $result = $callback();

            // Commit the transaction if all operations were successful
            DB::commit();

            return $result;
        } catch (\Exception $e) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Re-throw the exception after rollback
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    static public function handleToDateString($originalDateString)
    {
        $carbonDate = Carbon::createFromFormat('d-m-Y', $originalDateString);

        $formattedDate = $carbonDate->toDateString();

        return $formattedDate;
    }

    static public function parseReturnDate($date, $getAlsoTime = false)
    {
        if ($getAlsoTime) {
            return Carbon::parse($date)->format('d M Y h:i A');
        }

        return Carbon::parse($date)->format('d M Y');
    }

    static public function parseReturnImage($image)
    {
        if (is_null($image)) return "https://i.postimg.cc/PrdNTr8y/photo-2024-02-03-20-49-42.jpg";

        return asset(Storage::url($image));
    }
}
