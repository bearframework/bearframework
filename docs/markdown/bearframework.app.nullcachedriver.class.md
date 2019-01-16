# BearFramework\App\NullCacheDriver

implements [BearFramework\App\ICacheDriver](bearframework.app.icachedriver.class.md)

A null cache driver. No data is stored and no errors are thrown.

## Methods

##### public void [clear](bearframework.app.nullcachedriver.clear.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes all values from the cache.

##### public void [delete](bearframework.app.nullcachedriver.delete.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a value from the cache.

##### public void [deleteMultiple](bearframework.app.nullcachedriver.deletemultiple.method.md) ( array $keys )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes multiple values from the cache.

##### public mixed|null [get](bearframework.app.nullcachedriver.get.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieves a value from the cache.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns the stored value or null if not found or expired.

##### public array [getMultiple](bearframework.app.nullcachedriver.getmultiple.method.md) ( array $keys )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieves multiple values from the cache.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: An array (key/value) of found items.

##### public void [set](bearframework.app.nullcachedriver.set.method.md) ( string $key , type $value [, int $ttl ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores a value in the cache.

##### public void [setMultiple](bearframework.app.nullcachedriver.setmultiple.method.md) ( array $items [, int $ttl ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores multiple values in the cache.

## Details

File: /src/App/NullCacheDriver.php

---

[back to index](index.md)

