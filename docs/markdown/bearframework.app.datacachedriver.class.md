# BearFramework\App\DataCacheDriver

implements [BearFramework\App\ICacheDriver](bearframework.app.icachedriver.class.md)

A data cache driver. It uses the data repository provided to store the values.

## Methods

##### public [__construct](bearframework.app.datacachedriver.__construct.method.md) ( [BearFramework\App\DataRepository](bearframework.app.datarepository.class.md) $data )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new data cache driver.

##### public void [clear](bearframework.app.datacachedriver.clear.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes all values from the cache.

##### public void [delete](bearframework.app.datacachedriver.delete.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a value from the cache.

##### public void [deleteMultiple](bearframework.app.datacachedriver.deletemultiple.method.md) ( array $keys )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes multiple values from the cache.

##### public mixed|null [get](bearframework.app.datacachedriver.get.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieves a value from the cache.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns the stored value or null if not found or expired.

##### public array [getMultiple](bearframework.app.datacachedriver.getmultiple.method.md) ( array $keys )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieves multiple values from the cache.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: An array (key/value) of found items.

##### public void [set](bearframework.app.datacachedriver.set.method.md) ( string $key , type $value [, int $ttl ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores a value in the cache.

##### public void [setMultiple](bearframework.app.datacachedriver.setmultiple.method.md) ( array $items [, int $ttl ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores multiple values in the cache.

## Details

File: /src/App/DataCacheDriver.php

---

[back to index](index.md)

