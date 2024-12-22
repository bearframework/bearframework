# BearFramework\App\NullCacheDriver

A null cache driver. No data is stored and no errors are thrown.

```php
BearFramework\App\NullCacheDriver implements BearFramework\App\ICacheDriver {

	/* Methods */
	public void clear ( void )
	public void delete ( string $key )
	public void deleteMultiple ( array $keys )
	public mixed|null get ( string $key )
	public array getMultiple ( array $keys )
	public void set ( string $key , mixed $value [, int|null $ttl ] )
	public void setMultiple ( array $items [, int|null $ttl ] )

}
```

## Implements

##### [BearFramework\App\ICacheDriver](bearframework.app.icachedriver.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A cache driver interface.

## Methods

##### public void [clear](bearframework.app.nullcachedriver.clear.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes all values from the cache.

##### public void [delete](bearframework.app.nullcachedriver.delete.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a value from the cache.

##### public void [deleteMultiple](bearframework.app.nullcachedriver.deletemultiple.method.md) ( array $keys )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes multiple values from the cache.

##### public mixed|null [get](bearframework.app.nullcachedriver.get.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieves a value from the cache.

##### public array [getMultiple](bearframework.app.nullcachedriver.getmultiple.method.md) ( array $keys )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieves multiple values from the cache.

##### public void [set](bearframework.app.nullcachedriver.set.method.md) ( string $key , mixed $value [, int|null $ttl ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores a value in the cache.

##### public void [setMultiple](bearframework.app.nullcachedriver.setmultiple.method.md) ( array $items [, int|null $ttl ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores multiple values in the cache.

## Details

Location: ~/src/App/NullCacheDriver.php

---

[back to index](index.md)

