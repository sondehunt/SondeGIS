<?php

use App\ApproveToken;
use App\Hunter;
use App\LaunchSite;
use App\ReceiveStation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run() : void
    {
        factory(ApproveToken::class, 3000)->create()->each(
            static function (ApproveToken $approve_token) {
                $approve_token->receiveStations()->save(factory(ReceiveStation::class)->make());
            }
        );
        factory(ApproveToken::class, 3000)->create()->each(
            static function (ApproveToken $approve_token) {
                $approve_token->launchSites()->save(factory(LaunchSite::class)->make());
            }
        );
        factory(ApproveToken::class, 10000)->create()->each(
            static function (ApproveToken $approve_token) {
                $approve_token->hunters()->save(factory(Hunter::class)->make());
            }
        );
    }
}
