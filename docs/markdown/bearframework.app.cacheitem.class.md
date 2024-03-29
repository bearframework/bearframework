# BearFramework\App\CacheItem

```php
BearFramework\App\CacheItem {

	/* Properties */
	public string|null $key
	public int|null $ttl
	public mixed $value

	/* Methods */
	public __construct ( void )
	public array toArray ( [ array $options = [] ] )
	public string toJSON ( [ array $options = [] ] )

}
```

## Properties

##### public string|null $key

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The key of the cache item.

##### public int|null $ttl

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Time in seconds to stay in the cache.

##### public mixed $value

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The value of the cache item.

## Methods

##### public [__construct](bearframework.app.cacheitem.__construct.method.md) ( void )

##### public array [toArray](bearframework.app.cacheitem.toarray.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

##### public string [toJSON](bearframework.app.cacheitem.tojson.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

## Details

Location: ~/src/App/CacheItem.php

---

[back to index](index.md)

