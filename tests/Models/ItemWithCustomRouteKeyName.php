<?php

namespace ErikSulymosi\EloquentSqids\Tests\Models;

use ErikSulymosi\EloquentSqids\HasSqid;
use ErikSulymosi\EloquentSqids\SqidRouting;
use Illuminate\Database\Eloquent\Model;

class ItemWithCustomRouteKeyName extends Model
{
	use HasSqid;
	use SqidRouting;

	protected $guarded = [];

	protected $table = 'items';

	public function getRouteKeyName()
	{
		return 'slug';
	}
}