<?php

namespace ErikSulymosi\EloquentSqids\Tests;

use ErikSulymosi\EloquentSqids\Facades\Sqids;
use ErikSulymosi\EloquentSqids\Tests\Models\Comment;
use ErikSulymosi\EloquentSqids\Tests\Models\Item;
use ErikSulymosi\EloquentSqids\Tests\Models\ItemWithCustomRouteKeyName;
use ErikSulymosi\EloquentSqids\Tests\Models\Vendor;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;

it('can resolve a route binding', function () {
	$given = Item::factory()->create();

	$sqid = Sqids::encode([$given->getKey()]);

	Route::get('/item/{item}', function (Item $item) use ($given) {
		$this->assertEquals($given->id, $item->id);
	})->middleware(SubstituteBindings::class);

	$this->get("/item/$sqid");
});

it('supports custom route key names', function () {
	$given = ItemWithCustomRouteKeyName::create(
		Item::factory()->raw()
	);

	Route::get('/item/{item}', function (ItemWithCustomRouteKeyName $item) use ($given) {
		$this->assertEquals($given->id, $item->id);
	})->middleware(SubstituteBindings::class);

	$this->get("/item/$given->slug");

	Route::get('/admin/item/{item:sqid}', function (ItemWithCustomRouteKeyName $item) use ($given) {
		$this->assertEquals($given->id, $item->id);
	})->middleware(SubstituteBindings::class);

	$this->get("/admin/item/$given->sqid");

});

it('supports resolving softdeletable route bindings', function () {
	$given = Item::factory()->softDeleted()->create();

	$sqid = Sqids::encode([$given->getKey()]);

	Route::get('/item/{item}', function (Item $item) use ($given) {
		$this->assertEquals($given->id, $item->id);
	})->withTrashed()->middleware(SubstituteBindings::class);

	$this->get("/item/$sqid");
});

it('supports resolving child route bindings', function () {
	$item = Item::factory()->create();

	$given = $item->comments()->save(
		Comment::factory()->make()
	);

	Route::get(
		'/item/{item}/comments/{comment}', 
		function (Item $item, Comment $comment) use ($given) {
			$this->assertEquals($given->id, $comment->id);
		})->scopeBindings()->middleware(SubstituteBindings::class);

	$this->get("item/{$item->sqid}/comments/{$given->sqid}");

	$notRelated = Comment::factory()->create();

	$this->expectException(ModelNotFoundException::class);

	$this->get("item/{$item->sqid}/comments/{$notRelated->sqid}");
});

it('supports resolving special child route bindings', function () {
	$vendor = Vendor::factory()->create();

	$item = $vendor->items()->save(
		Item::factory()->make()
	);

	$given = $item->comments()->save(
		Comment::factory()->make()
	);

	Route::get(
		'/vendor/{vendor}/comments/{comment}', 
		function (Vendor $vendor, Comment $comment) use ($given) {
			$this->assertEquals($given->id, $comment->id);
		})->scopeBindings()->middleware(SubstituteBindings::class);		

	$this->get("/vendor/{$vendor->id}/comments/{$given->sqid}");
});


it('supports specifying a field in the route binding', function () {
	$given = Item::factory()->create(['slug' => 'item-1']);

	Route::get('/item/{item:slug}', function (Item $item) use ($given) {
		$this->assertEquals($given->id, $item->id);
	})->middleware(SubstituteBindings::class);

	$this->get("/item/item-1");
});

it('supports specifying the sqid in the route binding', function () {
	$given = Item::factory()->create();

	$sqid = Sqids::encode([$given->getKey()]);

	Route::get('/item/{item:sqid}', function (Item $item) use ($given) {
		$this->assertEquals($given->id, $item->id);
	})->middleware(SubstituteBindings::class);

	$this->get("/item/$sqid");
});


it('returns the sqid of the model as its route key', function () {
	$item = Item::factory()->create();

	$sqid = Sqids::encode([$item->id]);

	$this->assertEquals($sqid, $item->getRouteKey());
});
