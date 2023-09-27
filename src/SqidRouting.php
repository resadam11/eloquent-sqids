<?php

namespace ErikSulymosi\EloquentSqids;

use Illuminate\Support\Str;

trait SqidRouting
{
	/**
	 * @see parent
	 */
	public function resolveRouteBindingQuery($query, $value, $field = null)
	{
		$field = $field ?? $this->getRouteKeyName();

		if (
			$field && $field !== 'sqid' &&
			// Check for qualified columns
			Str::afterLast($field, '.') !== 'sqid' && 
			// Avoid risking breaking backward compatibility by modifying 
			// the getRouteKeyName() to return 'sqid' instead of null
			Str::afterLast($field, '.') !== ''
		) {
			return parent::resolveRouteBindingQuery($query, $value, $field);
		}

		return $query->bySqid($value);
	}

	/**
	 * @see parent
	 */
	public function getRouteKey()
	{
		return $this->sqid();
	}

	/**
	 * @see parent
	 */
	public function getRouteKeyName()
	{
		return null;
	}
}
