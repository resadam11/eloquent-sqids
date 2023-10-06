<?php

namespace ErikSulymosi\EloquentSqids\Tests\Models;

use ErikSulymosi\EloquentSqids\Eloquent\Traits\HasSqid;
use ErikSulymosi\EloquentSqids\Eloquent\Traits\SqidRouting;
use ErikSulymosi\EloquentSqids\Tests\Factories\ItemFactory;
use ErikSulymosi\EloquentSqids\Tests\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
	use HasSqid;
	use SqidRouting;
	use SoftDeletes;
	use HasFactory;

	protected $guarded = [];

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	/**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory()
    {
        return new ItemFactory();
    }
}