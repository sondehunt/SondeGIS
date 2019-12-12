<?php

use App\ApproveToken;
use App\ReceiveStation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run() : void
    {
        factory(ApproveToken::class, 942)->create()->each(static function (ApproveToken $approve_token) {
            $approve_token->receive_stations()->save(factory(ReceiveStation::class)->make());
        });
    }
}
