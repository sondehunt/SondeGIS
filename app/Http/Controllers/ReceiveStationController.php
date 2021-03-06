<?php

namespace App\Http\Controllers;

use App\Mail\ReceiveStationProposal;
use App\ReceiveStation;
use Illuminate\Http\Request;
use Mail;

class ReceiveStationController extends Controller
{
    public function index()
    {
        return ReceiveStation::approved()->get();
    }

    public function store(Request $request)
    {
        $receive_station = new ReceiveStation($request->get('receive_station'));
        $receive_station->proposal_email = $request->get('proposal')['email'];
        $receive_station->proposal_comment = $request->get('proposal')['comment'];
        $receive_station->makeApproveToken();
        $receive_station->save();
        Mail::send(new ReceiveStationProposal($receive_station), []);
        return response()->json();
    }

    public function proposal(Request $request, ReceiveStation $receive_station)
    {
        $proposal = new ReceiveStation($request->get('receive_station'));
        $proposal->proposal_email = $request->get('proposal')['email'];
        $proposal->proposal_comment = $request->get('proposal')['comment'];
        $proposal->makeApproveToken();
        $proposal->base()->associate($receive_station);
        $proposal->save();
        Mail::send(new ReceiveStationProposal($proposal), []);
        return response()->json();
    }
}
