<?php

namespace ErikSulymosi\EloquentSqids\Tests\Models;

use ErikSulymosi\EloquentSqids\HasSqid;
use ErikSulymosi\EloquentSqids\SqidRouting;
use ErikSulymosi\EloquentSqids\Tests\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	use HasSqid;
	use SqidRouting;
	use HasFactory;

	/**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory()
    {
        return new CommentFactory();
    }
}