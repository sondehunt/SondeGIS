<?php

namespace App;

use App\Traits\MustBeApproved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Hunter
 *
 * @property-read \App\ApproveToken $approveToken
 * @property-read \App\Hunter $base
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter approved()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Hunter onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Hunter withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Hunter withoutTrashed()
 * @mixin \Eloquent
 */
class Hunter extends Model
{
    use MustBeApproved;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'radius',
        'activity',
        'contact',
    ];

    protected $casts = [
        'contact' => 'array',
    ];
}
