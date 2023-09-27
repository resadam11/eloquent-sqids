<?php

namespace ErikSulymosi\EloquentSqids\Tests\Models;

use ErikSulymosi\EloquentSqids\Tests\Factories\VendorFactory;
use ErikSulymosi\EloquentSqids\Tests\Models\Comment;
use ErikSulymosi\EloquentSqids\Tests\Models\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
	use HasFactory;

	public function items()
	{
		return $this->hasMany(Item::class);
	}

	public function comments()
	{
		return $this->hasManyThrough(Comment::class, Item::class);
	}

	/**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory()
    {
        return new VendorFactory();
    }
}
