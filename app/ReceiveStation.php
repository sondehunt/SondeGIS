<?php

namespace App;

use App\Traits\MustBeApproved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ReceiveStation
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
 * @property float $lat
 * @property float $long
 * @property float|null $elevation
 * @property float|null $antenna_height
 * @property string|null $antenna_type
 * @property string|null $processing_system_type
 * @property int|null $concurrent_receivers
 * @property string|null $reporting_to
 * @property-read \App\ApproveToken $approveToken
 * @property-read \App\ReceiveStation|null $base
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation approved()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ReceiveStation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereAntennaHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereAntennaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereApproveTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereBaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereConcurrentReceivers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereElevation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereOperator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereProcessingSystemType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereProposalComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereProposalEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereReportingTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ReceiveStation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ReceiveStation withoutTrashed()
 * @mixin \Eloquent
 * @property float $latitude
 * @property float $longitude
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereLongitude($value)
 */
class ReceiveStation extends Model
{
    use MustBeApproved;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'operator',
        'latitude',
        'longitude',
        'elevation',
        'antenna_height',
        'antenna_type',
        'processing_system_type',
        'concurrent_receivers',
        'reporting_to',
    ];

    protected $casts = [
        'reporting_to' => 'array',
    ];
}
