<?php

namespace App\Http\Controllers;

use App\Hunter;
use App\Mail\HunterProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HunterController extends Controller
{
    public function index()
    {
        return Hunter::approved()->get();
    }

    public function store(Request $request)
    {
        $hunter = new Hunter($request->get('hunter'));
        $hunter->proposal_email = $request->get('proposal')['email'];
        $hunter->proposal_comment = $request->get('proposal')['comment'];
        $hunter->makeApproveToken();
        $hunter->save();
        Mail::send(new HunterProposal($hunter), []);
        return response()->json();
    }

    public function proposal(Request $request, Hunter $hunter)
    {
        $proposal = new Hunter($request->get('hunter'));
        $proposal->proposal_email = $request->get('proposal')['email'];
        $proposal->proposal_comment = $request->get('proposal')['comment'];
        $proposal->makeApproveToken();
        $proposal->base()->associate($hunter);
        $proposal->save();
        return response()->json();
    }
}
