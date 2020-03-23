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
            ->whereNotNull($from . '.approved_at')
            ->where('head', '=', 1);
    }

    /**
     * @param Builder $query
     * @param $id
     * @return mixed
     */
    public function scopeOfBase($query, $id)
    {
        /** @var Builder $builder */
        return $query->where(
            static function (Builder $builder) use ($id) {
                $builder->where(
                    static function (Builder $builder) use ($id) {
                        $builder->where('base_id', '=', $id);
                    }
                )->orWhere(
                    static function (Builder $builder) use ($id) {
                        $builder->whereNull('base_id');
                        $builder->where('id', '=', $id);
                    }
                );
            }
        );
    }

    public static function findBase(int $id)
    {
        /** @var Builder $builder */
        $builder = static::query();
        return $builder
            ->whereNotNull('approved_at')
            ->where(
                static function (Builder $builder) use ($id) {
                    $builder->where(
                        static function (Builder $builder) use ($id) {
                            $builder->where('base_id', '=', $id);
                        }
                    )->orWhere(
                        static function (Builder $builder) use ($id) {
                            $builder->whereNull('base_id');
                            $builder->where('id', '=', $id);
                        }
                    );
                }
            )
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

    public function approve() : void
    {
        static::ofBase($this->base_id ?? $this->id)->update(['head' => false]);
        $this->approved_at = now();
        $this->head = true;
        $this->save();
    }
}
