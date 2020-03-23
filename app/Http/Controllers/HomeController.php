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
            return view('index', ['launch_site' => $launchSite, 'token' => $token]);
        }
        return 'token invalid';
    }

    public function approveReceiveStation(ReceiveStation $receiveStation, string $token)
    {
        if ($receiveStation->approveToken->token === $token) {
            $receiveStation->approved_at = Carbon::now();
            $receiveStation->save();
            return view('index', ['receive_station' => $receiveStation, 'token' => $token]);
        }
        return 'token invalid';
    }

    public function approveHunter(Hunter $hunter, string $token)
    {
        if ($hunter->approveToken->token === $token) {
            return view('index', ['hunter' => $hunter, 'token' => $token]);
        }
        return 'token invalid';
    }
}
