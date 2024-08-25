<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Resources\Category\CategoryDetailResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            try {
                $this->authorize("checkPermission", "all");
            } catch (\Throwable $th) {
                return response()->json(["message" => "လုပ်ပိုင်ခွင့်မရှိပါ"], 403);
            }

            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = HelperController::findAllQuery(Category::class, $request, ["name", "remark"]);

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        if (!(is_null($request->parent_id))) {
            $category = Category::find(decrypt($request->parent_id));
            if (!(is_null($category))) {
                Category::create([
                    "name" => $request->name,
                    "parent_id" => decrypt($request->parent_id),
                    "remark" => $request->remark
                ]);
            } else  return response()->json(["message" => "အမျိုးအစားမရှိပါ"], 400);
        } else {
            Category::create([
                "name" => $request->name,
                "parent_id" => null,
                "remark" => $request->remark
            ]);
        }

        return response()->json(["message" => "အမျိုးအစားထည့်သွင်းခြင်း အောင်မြင်ပါသည်"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find(decrypt($id));
        if (is_null($category)) {
            return response()->json(["message" => "အမျိုးအစားမရှိပါ"]);
        }

        return new CategoryDetailResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find(decrypt($id));

        if (is_null($category)) {
            return response()->json(["message" => "အမျိုးအစားမရှိပါ"], 404);
        }

        $category->name = $request->name ?? $category->name;
        $category->remark = $request->remark ?? $category->remark;
        $category->parent_id = $request->parent_id;
        $category->update();

        return response()->json(["message" => "အမျိုးအစားပြင်ဆင်ခြင်း အောင်မြင်ပါသည်"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find(decrypt($id));

        if (is_null($category)) {
            return response()->json(["message" => "အမျိုးအစားမရှိပါ"], 404);
        }

        $category->delete();

        return response()->json(["message" => "အမျိုးအစားပယ်ဖျက်ခြင်း အောင်မြင်ပါသည်"]);
    }
}
