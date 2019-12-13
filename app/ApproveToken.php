<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * App\ApproveToken
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $token
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApproveToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApproveToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApproveToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApproveToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApproveToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApproveToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApproveToken whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ReceiveStation[] $receive_stations
 * @property-read int|null $receive_stations_count
 */
class ApproveToken extends Model
{
    protected $fillable = [
        'token',
    ];

    public static function generate() : string
    {
        return Str::random(256);
    }

    public function receiveStations() : HasMany
    {
        return $this->hasMany(ReceiveStation::class);
    }

    public function launchSites() : HasMany
    {
        return $this->hasMany(LaunchSite::class);
    }

    public function hunters() : HasMany
    {
        return $this->hasMany(Hunter::class);
    }
}
