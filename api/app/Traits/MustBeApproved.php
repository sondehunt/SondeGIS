<?php


namespace App\Traits;


use App\ApprovedScope;
use App\ApproveToken;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait MustBeApproved
{
    use HasRelationships;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot() : void
    {
        parent::boot();
    }

    public function approveToken() : BelongsTo
    {
        return $this->belongsTo(ApproveToken::class);
    }

    public function base() : BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'base_id');
    }

    public function makeApproveToken() : void
    {
        $token = new ApproveToken();
        $token->token = ApproveToken::generate();
        $token->save();
        $this->approveToken()->associate($token);
    }
}
