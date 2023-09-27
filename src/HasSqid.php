<?php

namespace ErikSulymosi\EloquentSqids;

use Illuminate\Database\Eloquent\Model;
use Sqids\Laravel\Facades\Sqids;

/**
 * @method Model|null findBySqid($sqid)
 * @method Model findBySqidOrFail($sqid)
 */
trait HasSqid 
{
	public static function bootHasSqid()
	{
		static::addGlobalScope(new SqidScope);
	}

	public function sqid(): string|null
	{
		return $this->idToSqid($this->getKey());
	}

	/**
	 * Decode the sqid to the id
	 */
	public function sqidToId(string $sqid): int|null
	{
		return Sqids::decode($sqid)[0] ?? null;
	}

	/**
	 * Encode an id to its equivalent sqid
	 */
	public function idToSqid(int $id): string|null
	{
		return Sqids::encode([$id]);
	}

	protected function getSqidAttribute()
    {
        return $this->sqid();
    }
}
