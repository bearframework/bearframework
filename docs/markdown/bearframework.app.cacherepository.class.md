# BearFramework\App\CacheRepository

Data cache

```php
BearFramework\App\CacheRepository {

	/* Methods */
	public self addEventListener ( string $name , callable $listener )
	public self clear ( void )
	public self delete ( string $key )
	public self dispatchEvent ( string $name [, mixed $details [, array $options = [] ]] )
	public bool exists ( string $key )
	public BearFramework\App\CacheItem|null get ( string $key )
	public mixed getValue ( string $key )
	public bool hasEventListeners ( string $name )
	public BearFramework\App\CacheItem make ( [ string|null $key [, string|null $value ]] )
	public self removeEventListener ( string $name , callable $listener )
	public self set ( BearFramework\App\CacheItem $item )
	public self setDriver ( BearFramework\App\ICacheDriver $driver )
	public self useAppDataDriver ( [ string $keyPrefix = '.temp/cache/' ] )
	public self useNullDriver ( void )

}
```

## Methods

##### public self [addEventListener](bearframework.app.cacherepository.addeventlistener.method.md) ( string $name , callable $listener )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers a new event listener.

##### public self [clear](bearframework.app.cacherepository.clear.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes all values from the cache.

##### public self [delete](bearframework.app.cacherepository.delete.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes an item from the cache.

##### public self [dispatchEvent](bearframework.app.cacherepository.dispatchevent.method.md) ( string $name [, mixed $details [, array $options = [] ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Calls the registered listeners (in order) for the event name specified.

##### public bool [exists](bearframework.app.cacherepository.exists.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether a key exists in the cache.

##### public [BearFramework\App\CacheItem](bearframework.app.cacheitem.class.md)|null [get](bearframework.app.cacherepository.get.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the cache item stored or null if not found.

##### public mixed [getValue](bearframework.app.cacherepository.getvalue.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value of the cache item specified.

##### public bool [hasEventListeners](bearframework.app.cacherepository.haseventlisteners.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns TRUE if there are registered event listeners for the name specified, FALSE otherwise.

##### public [BearFramework\App\CacheItem](bearframework.app.cacheitem.class.md) [make](bearframework.app.cacherepository.make.method.md) ( [ string|null $key [, string|null $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new cache item and returns it.

##### public self [removeEventListener](bearframework.app.cacherepository.removeeventlistener.method.md) ( string $name , callable $listener )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Removes a registered event listener.

##### public self [set](bearframework.app.cacherepository.set.method.md) ( [BearFramework\App\CacheItem](bearframework.app.cacheitem.class.md) $item )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores a cache item.

##### public self [setDriver](bearframework.app.cacherepository.setdriver.method.md) ( [BearFramework\App\ICacheDriver](bearframework.app.icachedriver.class.md) $driver )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a new cache driver.

##### public self [useAppDataDriver](bearframework.app.cacherepository.useappdatadriver.method.md) ( [ string $keyPrefix = '.temp/cache/' ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enables the app cache driver. The cached data will be stored in the app data repository.

##### public self [useNullDriver](bearframework.app.cacherepository.usenulldriver.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enables the null cache driver. No data is stored and no errors are thrown.

## Events

##### null clear

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the cache is cleared.

##### [BearFramework\App\Cache\ItemChangeEventDetails](bearframework.app.cache.itemchangeeventdetails.class.md) itemChange

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a cache item is changed.

##### [BearFramework\App\Cache\ItemDeleteEventDetails](bearframework.app.cache.itemdeleteeventdetails.class.md) itemDelete

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a cache item is deleted.

##### [BearFramework\App\Cache\ItemExistsEventDetails](bearframework.app.cache.itemexistseventdetails.class.md) itemExists

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a cache item is checked for existence.

##### [BearFramework\App\Cache\ItemGetEventDetails](bearframework.app.cache.itemgeteventdetails.class.md) itemGet

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a cache item is requested.

##### [BearFramework\App\Cache\ItemGetValueEventDetails](bearframework.app.cache.itemgetvalueeventdetails.class.md) itemGetValue

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the value of a cache item is requested.

##### [BearFramework\App\Cache\ItemRequestEventDetails](bearframework.app.cache.itemrequesteventdetails.class.md) itemRequest

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a cache item is requested.

##### [BearFramework\App\Cache\ItemSetEventDetails](bearframework.app.cache.itemseteventdetails.class.md) itemSet

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a cache item is added or updated.

## Details

Location: ~/src/App/CacheRepository.php

---

[back to index](index.md)

