<?php

namespace App\Http\Controllers;

use App\LaunchSite;
use App\Mail\LaunchSiteProposal;
use Illuminate\Http\Request;
use Mail;

class LaunchSiteController extends Controller
{
    public function index()
    {
        return LaunchSite::approved()->get();
    }

    public function store(Request $request)
    {
        $launchSite = new LaunchSite($request->get('launch_site'));
        $launchSite->proposal_email = $request->get('proposal')['email'];
        $launchSite->proposal_comment = $request->get('proposal')['comment'];
        $launchSite->makeApproveToken();
        $launchSite->save();
        Mail::send(new LaunchSiteProposal($launchSite), []);
        return response()->json();
    }

    public function proposal(Request $request, LaunchSite $launchSite)
    {
        $proposal = new LaunchSite($request->get('launch_site'));
        $proposal->proposal_email = $request->get('proposal')['email'];
        $proposal->proposal_comment = $request->get('proposal')['comment'];
        $proposal->makeApproveToken();
        $proposal->base()->associate($launchSite);
        $proposal->save();
        Mail::send(new LaunchSiteProposal($proposal), []);
        return response()->json();
    }

    public function approve(Request $request, LaunchSite $proposal)
    {
        $token = $request->get('token');
        if ($proposal->approveToken->token === $token) {
            $proposal->update($request->all());
            $proposal->approve();
            return response()->json(['success' => true]);
        }
        return response()->json();
    }
}
