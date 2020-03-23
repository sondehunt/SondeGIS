<?php

namespace App;

use App\Traits\MustBeApproved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\LaunchSite
 *
 * @property int $id
 * @property int|null $base_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $approve_token_id
 * @property string|null $approved_at
 * @property string|null $proposal_email
 * @property string|null $proposal_comment
 * @property string $name
 * @property string $operator
 * @property int|null $wmo_id
 * @property float|null $lat
 * @property float|null $long
 * @property float|null $elevation
 * @property string|null $type
 * @property string|null $primary_frequency
 * @property string|null $secondary_frequencies
 * @property string|null $balloon
 * @property string|null $gas
 * @property string|null $parachute
 * @property string|null $annotations
 * @property-read \App\ApproveToken $approveToken
 * @property-read \App\LaunchSite|null $base
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite approved()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\LaunchSite onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereAnnotations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereApproveTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereBalloon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereBaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereElevation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereGas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereOperator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereParachute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite wherePrimaryFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereProposalComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereProposalEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereSecondaryFrequencies($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereWmoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LaunchSite withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\LaunchSite withoutTrashed()
 * @mixin \Eloquent
 * @property int|null $wmo-id
 * @property array|null $launch
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereLaunch($value)
 * @property float|null $latitude
 * @property float|null $longitude
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereLongitude($value)
 * @property bool $head
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite ofBase()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LaunchSite whereHead($value)
 */
class LaunchSite extends Model
{
    use MustBeApproved;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'operator',
        'wmo_id',
        'latitude',
        'longitude',
        'elevation',
        'launch',
    ];

    protected $casts = [
        'head' => 'boolean',
        'launch' => 'array',
    ];
}
