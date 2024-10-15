<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\Delivery\DeliService;
use App\Http\Services\Delivery\DeliWayExcelService;
use App\Http\Services\Delivery\DeliWayService;
use Illuminate\Http\Request;

class DeliController extends Controller
{
    public function store(Request $request)
    {
        return DeliService::create($request);
    }

    public function index(Request $request)
    {
        return DeliService::index($request);
    }

    public function show(string $id)
    {
        return DeliService::show($id);
    }

    public function update(Request $request, string $id)
    {
        return DeliService::update($id, $request);
    }

    public function destroy(string $id)
    {
        return DeliService::destroy($id);
    }

    public function deliWay(Request $request)
    {
        return DeliWayService::deliWay($request);
    }

    public function excelExport(Request $request)
    {
        return DeliWayExcelService::execute($request);
    }
}
