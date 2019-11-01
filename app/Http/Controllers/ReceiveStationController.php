<?php

namespace App\Http\Controllers;

use App\ReceiveStation;
use Illuminate\Http\Request;

class ReceiveStationController extends Controller
{
    public function index(Request $request)
    {
        return ReceiveStation::all();
    }

    public function store(Request $request)
    {
        $receive_station = new ReceiveStation($request->all());
        $receive_station->submitted_by = $request->get('submitted_by');
        $receive_station->makeApproveToken();
        $receive_station->save();
        return response()->json();
    }

    public function proposal(Request $request, ReceiveStation $receive_station)
    {
        $proposal = new ReceiveStation($request->all());
        $proposal->submitted_by = $request->get('submitted_by');
        $proposal->makeApproveToken();
        $proposal->base()->associate($receive_station);
        $proposal->save();
        return response()->json();
    }
}
