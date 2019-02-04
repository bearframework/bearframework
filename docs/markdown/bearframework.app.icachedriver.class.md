# BearFramework\App\ICacheDriver

A cache driver interface.

```php
BearFramework\App\ICacheDriver {

	/* Methods */
	public abstract void clear ( void )
	public abstract void delete ( string $key )
	public abstract void deleteMultiple ( array $keys )
	public abstract mixed|null get ( string $key )
	public abstract array getMultiple ( array $keys )
	public abstract void set ( string $key , type $value [, int $ttl ] )
	public abstract void setMultiple ( array $items [, int $ttl ] )

}
```

## Methods

##### public abstract void [clear](bearframework.app.icachedriver.clear.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes all values from the cache.

##### public abstract void [delete](bearframework.app.icachedriver.delete.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a value from the cache.

##### public abstract void [deleteMultiple](bearframework.app.icachedriver.deletemultiple.method.md) ( array $keys )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes multiple values from the cache.

##### public abstract mixed|null [get](bearframework.app.icachedriver.get.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieves a value from the cache.

##### public abstract array [getMultiple](bearframework.app.icachedriver.getmultiple.method.md) ( array $keys )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieves multiple values from the cache.

##### public abstract void [set](bearframework.app.icachedriver.set.method.md) ( string $key , type $value [, int $ttl ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores a value in the cache.

##### public abstract void [setMultiple](bearframework.app.icachedriver.setmultiple.method.md) ( array $items [, int $ttl ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores multiple values in the cache.

## Details

Location: ~/src/App/DataCacheDriver.php

---

[back to index](index.md)

