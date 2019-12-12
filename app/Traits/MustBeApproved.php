<?php


namespace App\Traits;


use App\ApproveToken;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Trait MustBeApproved
 * @package App\Traits
 */
trait MustBeApproved
{
    use HasRelationships;

    public function scopeApproved()
    {
        /** @var Builder $builder */
        $builder = static::query();
        $from = $this->getTable();
        return $builder
            ->where('id', '=', function (\Illuminate\Database\Query\Builder $query) use ($from) {
                $query
                    ->selectRaw('max(id)')
                    ->from($from, 'r')
                    ->whereNotNull($from . '.approved_at')
                    ->where($from . '.approved_at', '=',
                        static function (\Illuminate\Database\Query\Builder $query) use ($from) {
                            $query
                                ->selectRaw('max(r2.approved_at)')
                                ->from($from, 'r2')
                                ->whereRaw('coalesce(r2.base_id, r2.id) = coalesce(r.base_id, r.id)');
                        })
                    ->whereRaw('coalesce(r.base_id, r.id) = coalesce(' . $from . '.base_id, ' . $from . '.id)');
            });
    }

    public static function findBase(int $id)
    {
        /** @var Builder $builder */
        $builder = static::query();
        return $builder
            ->whereNotNull('approved_at')
            ->where(static function (Builder $builder) use ($id) {
                $builder->where(static function (Builder $builder) use ($id) {
                    $builder->where('base_id', '=', $id);
                })->orWhere(static function (Builder $builder) use ($id) {
                    $builder->whereNull('base_id');
                    $builder->where('id', '=', $id);
                });
            })
            ->orderByDesc('approved_at')
            ->first();
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
