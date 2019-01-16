# BearFramework\App\CacheRepository

Data cache

## Methods

##### public [__construct](bearframework.app.cacherepository.__construct.method.md) ( [BearFramework\App](bearframework.app.class.md) $app )

##### public void [addEventListener](bearframework.app.cacherepository.addeventlistener.method.md) ( string $name , callable $listener )

##### public void [clear](bearframework.app.cacherepository.clear.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes all values from the cache.

##### public self [delete](bearframework.app.cacherepository.delete.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a cache from the cache.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public void [dispatchEvent](bearframework.app.cacherepository.dispatchevent.method.md) ( [BearFramework\App\Event](bearframework.app.event.class.md) $event )

##### public bool [exists](bearframework.app.cacherepository.exists.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether a key exists in the cache.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: TRUE if the cache item exists in the cache, FALSE otherwise.

##### public [BearFramework\App\CacheItem](bearframework.app.cacheitem.class.md)|null [get](bearframework.app.cacherepository.get.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the cache item stored or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The cache item stored or null if not found.

##### public mixed [getValue](bearframework.app.cacherepository.getvalue.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value of the cache item specified.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The value of the cache item or null if not found.

##### public bool [hasEventListeners](bearframework.app.cacherepository.haseventlisteners.method.md) ( string $name )

##### public [BearFramework\App\CacheItem](bearframework.app.cacheitem.class.md) [make](bearframework.app.cacherepository.make.method.md) ( [ string $key [,  $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new cache item and returns it.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a new cache item.

##### public void [removeEventListener](bearframework.app.cacherepository.removeeventlistener.method.md) ( string $name , callable $listener )

##### public self [set](bearframework.app.cacherepository.set.method.md) ( [BearFramework\App\CacheItem](bearframework.app.cacheitem.class.md) $item )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores a cache item.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public void [setDriver](bearframework.app.cacherepository.setdriver.method.md) ( [BearFramework\App\ICacheDriver](bearframework.app.icachedriver.class.md) $driver )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a new cache driver.

##### public void [useAppDataDriver](bearframework.app.cacherepository.useappdatadriver.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enables the app cache driver. The cached data will be stored in the app data repository.

##### public void [useNullDriver](bearframework.app.cacherepository.usenulldriver.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enables the null cache driver. No data is stored and no errors are thrown.

## Events

##### clear

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Cache\ClearEvent](bearframework.app.cache.clearevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the cache is cleared.

##### itemChange

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Cache\ItemChangeEvent](bearframework.app.cache.itemchangeevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a cache item is changed.

##### itemDelete

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Cache\ItemDeleteEvent](bearframework.app.cache.itemdeleteevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a cache item is deleted.

##### itemExists

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Cache\ItemExistsEvent](bearframework.app.cache.itemexistsevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a cache item is checked for existence.

##### itemGet

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Cache\ItemGetEvent](bearframework.app.cache.itemgetevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a cache item is requested.

##### itemGetValue

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Cache\ItemGetValueEvent](bearframework.app.cache.itemgetvalueevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the value of a cache item is requested.

##### itemRequest

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Cache\ItemRequestEvent](bearframework.app.cache.itemrequestevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a cache item is requested.

##### itemSet

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Cache\ItemSetEvent](bearframework.app.cache.itemsetevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a cache item is added or updated.

## Details

File: /src/App/CacheRepository.php

---

[back to index](index.md)

