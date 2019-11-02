<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
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
}
