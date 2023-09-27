> Using sqids instead of integer ids in urls and list items can be more
appealing and clever. For more information visit [sqids.org](https://sqids.org/).

> This package is based on mtvs's ![eloquent-hashids](https://github.com/mtvs/eloquent-hashids) package.

# Eloquent-Sqids ![Build Status](https://github.com/eriksulymosi/eloquent-sqids/actions/workflows/build.yml/badge.svg)

This adds sqids to Laravel Eloquent models by encoding/decoding them on the fly
rather than persisting them in the database. So no need for another database column
and also higher performance by using primary keys in queries.

Features include:

* Generating sqids for models
* Resloving sqids to models
* Ability to customize sqid settings for each model
* Route binding with sqids (optional)

## Installation

Install the package with Composer:

```sh

$ composer require mtvs/eloquent-sqids

```

Also, publish the vendor config files to your application (necessary for the dependencies):

```sh
$ php artisan vendor:publish
```

## Setup

Base features are provided by using `HasSqid` trait then route binding with
sqids can be added by using `SqidRouting`.

```php

use Illuminate\Database\Eloquent\Model;
use ErikSulymosi\EloquentSqids\HasSqid;
use ErikSulymosi\EloquentSqids\SqidRouting;

Class Item extends Model
{
	use HasSqid, SqidRouting;
}

```

## Usage

### Basics

```php

// Generating the model sqid based on its key
$item->sqid();

// Equivalent to the above but with the attribute style
$item->sqid;

// Finding a model based on the provided sqid or
// returning null on failure
Item::findBySqid($sqid);

// Finding a model based on the provided sqid or
// throwing a ModelNotFoundException on failure
Item::findBySqidOrFail($sqid);

// Decoding a sqid to its equivalent id 
$item->sqidToId($sqid);

// Encoding an id to its equivalent sqid
$item->idToSqid($id);

// Getting the name of the sqid connection
$item->getSqidsConnection();

```

### Add the sqid to the serialized model

Set it as default:

```php

use Illuminate\Database\Eloquent\Model;
use ErikSulymosi\EloquentSqids\HasSqid;

class Item extends Model
{
    use HasSqid;
    
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['sqid'];
}

```

or specify it specificly:

`return $item->append('sqid')->toJson();`


### Implicit Route Bindings

If you want to resolve implicit route bindings for the model using its hahsid
value you can use `SqidRouting` in the model.

```php

use Illuminate\Database\Eloquent\Model;
use ErikSulymosi\EloquentSqids\HasSqid;
use ErikSulymosi\EloquentSqids\SqidRouting;

class Item extends Model
{
    use HasSqid, SqidRouting;
}

```
It overwrites `getRouteKeyName()`, `getRouteKey()` and `resolveRouteBindingQuery()`
to use the sqids as the route keys.

It supports the Laravel's feature for customizing the key for specific routes.

```php

Route::get('/items/{item:slug}', function (Item $item) {
    return $item;
});

```

#### Customizing The Default Route Key Name

If you want to by default resolve the implicit route bindings using another 
field you can overwrite `getRouteKeyName()` to return the field's name to the
resolving process and `getRouteKey()` to return its value in your links.

```php

use Illuminate\Database\Eloquent\Model;
use ErikSulymosi\EloquentSqids\HasSqid;
use ErikSulymosi\EloquentSqids\SqidRouting;

class Item extends Model
{
    use HasSqid, SqidRouting;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getRouteKey()
    {
        return $this->slug;
    }
}

```

You'll still be able to specify the sqid for specific routes.

```php

Route::get('/items/{item:sqid}', function (Item $item) {
    return $item;
});

```

#### Supporting The Other Laravel's Implicit Route Binding Features

When using `SqidRouting` you'll still be able to use softdeletable and child
route bindings.

```php

Route::get('/items/{item}', function (Item $item) {
    return $item;
})->withTrashed();

Route::get('/user/{user}/items/{item}', function (User $user, Item $item) {
    return $item;
})->scopeBindings();

```

