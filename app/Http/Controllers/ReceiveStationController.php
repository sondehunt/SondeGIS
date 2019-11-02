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
        $receive_station = new ReceiveStation($request->get('receive_station'));
        $receive_station->proposal_email = $request->get('proposal_email');
        $receive_station->proposal_comment = $request->get('proposal_comment');
        $receive_station->makeApproveToken();
        $receive_station->save();
        return response()->json();
    }

    public function proposal(Request $request, ReceiveStation $receive_station)
    {
        $proposal = new ReceiveStation($request->get('receive_station'));
        $proposal->proposal_email = $request->get('proposal_email');
        $proposal->proposal_comment = $request->get('proposal_comment');
        $proposal->makeApproveToken();
        $proposal->base()->associate($receive_station);
        $proposal->save();
        return response()->json();
    }
}
