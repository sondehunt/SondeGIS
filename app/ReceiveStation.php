<?php

namespace App;

use App\Traits\MustBeApproved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ReceiveStation
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $approved_at
 * @property string|null $submitted_by
 * @property string $name
 * @property string $operator
 * @property string|null $wmo_id
 * @property float $lat
 * @property float $long
 * @property float|null $elevation
 * @property float|null $antenna_height
 * @property string|null $antenna_type
 * @property string|null $processing_system_type
 * @property int|null $concurrent_receivers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereAntennaHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereAntennaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereApprovedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereSubmittedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereWmoId($value)
 * @mixin \Eloquent
 * @property int $approve_token_id
 * @property-read \App\ApproveToken $approveToken
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReceiveStation whereApproveTokenId($value)
 */
class ReceiveStation extends Model
{
    use MustBeApproved;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'operator',
        'lat',
        'long',
        'elevation',
        'antenna_height',
        'antenna_type',
        'processing_system_type',
        'concurrent_receivers',
        'reporting_to',
    ];
}
