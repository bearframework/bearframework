# BearFramework\App\ICacheDriver

A cache driver interface.

```php
BearFramework\App\ICacheDriver {

	/* Methods */
	abstract public void clear ( void )
	abstract public void delete ( string $key )
	abstract public void deleteMultiple ( array $keys )
	abstract public mixed|null get ( string $key )
	abstract public array getMultiple ( array $keys )
	abstract public void set ( string $key , mixed $value [, int|null $ttl ] )
	abstract public void setMultiple ( array $items [, int|null $ttl ] )

}
```

## Methods

##### abstract public void [clear](bearframework.app.icachedriver.clear.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes all values from the cache.

##### abstract public void [delete](bearframework.app.icachedriver.delete.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a value from the cache.

##### abstract public void [deleteMultiple](bearframework.app.icachedriver.deletemultiple.method.md) ( array $keys )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes multiple values from the cache.

##### abstract public mixed|null [get](bearframework.app.icachedriver.get.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieves a value from the cache.

##### abstract public array [getMultiple](bearframework.app.icachedriver.getmultiple.method.md) ( array $keys )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieves multiple values from the cache.

##### abstract public void [set](bearframework.app.icachedriver.set.method.md) ( string $key , mixed $value [, int|null $ttl ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores a value in the cache.

##### abstract public void [setMultiple](bearframework.app.icachedriver.setmultiple.method.md) ( array $items [, int|null $ttl ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores multiple values in the cache.

## Details

Location: ~/src/App/DataCacheDriver.php

---

[back to index](index.md)

