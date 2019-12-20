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
 * @property float $latitude
 * @property float $longitude
 * @property float $radius
 * @property float $activity
 * @property array|null $contact
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter whereActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter whereApproveTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter whereBaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter whereProposalComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter whereProposalEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter whereRadius($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hunter whereUpdatedAt($value)
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
