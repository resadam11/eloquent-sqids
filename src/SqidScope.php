<?php

namespace ErikSulymosi\EloquentSqids;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SqidScope implements Scope
{
	public function apply(Builder $builder, Model $model)
	{
		
	}

	public function extend(Builder $builder)
	{
		$builder->macro('findBySqid', function (Builder $builder, $sqid) {
			return $builder->bySqid($sqid)->first();
		});

		$builder->macro('findBySqidOrFail', function (Builder $builder, $sqid)
		{
			return $builder->bySqid($sqid)->firstOrFail();
		});

		$builder->macro('bySqid', function (Builder $builder, $sqid) {
			$model = $builder->getModel();

			return $builder->where(
					$model->qualifyColumn($model->getKeyName()),
				 	$model->sqidToId($sqid)
				);
		});
	}
}