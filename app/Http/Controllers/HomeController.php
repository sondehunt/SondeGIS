<?php

namespace App\Http\Controllers;

use App\Hunter;
use App\LaunchSite;
use App\ReceiveStation;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function approveLaunchSite(LaunchSite $launchSite, string $token)
    {
        if ($launchSite->approveToken->token === $token) {
            $launchSite->approved_at = Carbon::now();
            $launchSite->save();
            return 'proposal approved';
        }
        return 'token invalid';
    }

    public function approveReceiveStation(ReceiveStation $receiveStation, string $token)
    {
        if ($receiveStation->approveToken->token === $token) {
            $receiveStation->approved_at = Carbon::now();
            $receiveStation->save();
            return 'proposal approved';
        }
        return 'token invalid';
    }

    public function approveHunter(Hunter $hunter, string $token)
    {
        if ($hunter->approveToken->token === $token) {
            $hunter->approved_at = Carbon::now();
            $hunter->save();
            return 'proposal approved';
        }
        return 'token invalid';
    }
}
