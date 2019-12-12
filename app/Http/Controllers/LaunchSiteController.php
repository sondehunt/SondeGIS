<?php

namespace App\Http\Controllers;

use App\LaunchSite;
use Illuminate\Http\Request;

class LaunchSiteController extends Controller
{
    public function index()
    {
        return LaunchSite::approved()->get();
    }

    public function store(Request $request)
    {
        $receive_station = new LaunchSite($request->get('launch_site'));
        $receive_station->proposal_email = $request->get('proposal')['email'];
        $receive_station->proposal_comment = $request->get('proposal')['comment'];
        $receive_station->makeApproveToken();
        $receive_station->save();
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
        return response()->json();
    }
}
