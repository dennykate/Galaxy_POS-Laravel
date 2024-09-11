<?php

namespace App\Http\Services\Delivery;

use App\Http\Controllers\HelperController;
use App\Http\Resources\DeliResource;
use App\Models\DeliWay;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeliService
{
    public static function create(Request $request)
    {
        $new_deli = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'role' => 'staff',
            'password' => Hash::make($request->password)
        ]);

        $deli_way = DeliWay::create(['user_id' => $new_deli->id, 'cities' => $request->cities]);

        return response()->json(['data' => $new_deli]);
    }

    public static function index(Request $request)
    {
        $delis = HelperController::findAllQuery(new User(), $request, ['name', 'phone', 'email'], [
            ['role', '=', 'staff']
        ]);

        return DeliResource::collection($delis);
    }

    public static function show(string $id)
    {
        $deli = User::find($id);

        if (!$deli) throw new NotFoundHttpException('Deli not found');

        return new DeliResource($deli);
    }

    public static function update(string $id, Request $request)
    {
        $deli_user = User::find($id);

        if (!$deli_user) throw new NotFoundHttpException('Deli not found');

        $deli_user->name = $request->name ?? $deli_user->name;
        $deli_user->phone = $request->phone ?? $deli_user->phone;
        $deli_user->password = $request->password ? Hash::make($request->password) : $deli_user->password;

        $deli_user->save();

        $deli = DeliWay::where('user_id', $id)->first();

        $deli->cities = $request->cities ?? $deli->cities;
        $deli->save();

        return new DeliResource($deli_user);
    }

    public static function destroy(string $id)
    {
        $deli_man = User::find($id);
        $deli = DeliWay::where('user_id', $id)->first();

        $deli_man->delete();
        $deli->delete();

        return response()->json(['message' => 'Delivery has been deleted successfully']);
    }
}
