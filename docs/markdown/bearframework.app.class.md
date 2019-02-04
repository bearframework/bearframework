# BearFramework\App

The is the class used to instantiate you application.

```php
BearFramework\App {

	/* Properties */
	public readonly BearFramework\App\AddonsRepository $addons
	public readonly BearFramework\App\Assets $assets
	public readonly BearFramework\App\CacheRepository $cache
	public readonly BearFramework\App\ClassesRepository $classes
	public readonly BearFramework\App\ContextsRepository $contexts
	public readonly BearFramework\App\DataRepository $data
	public readonly BearFramework\App\LogsRepository $logs
	public readonly BearFramework\App\Request $request
	public readonly BearFramework\App\RoutesRepository $routes
	public readonly BearFramework\App\ShortcutsRepository $shortcuts
	public readonly BearFramework\App\Urls $urls

	/* Methods */
	public __construct ( void )
	public void addEventListener ( string $name , callable $listener )
	protected self defineProperty ( string $name [, array $options = [] ] )
	public void dispatchEvent ( BearFramework\App\Event $event )
	public void enableErrorHandler ( [ array $options = [] ] )
	public static BearFramework\App get ( void )
	public bool hasEventListeners ( string $name )
	public void removeEventListener ( string $name , callable $listener )
	public void run ( void )
	public void send ( BearFramework\App\Response $response )

}
```

## Properties

##### public readonly [BearFramework\App\AddonsRepository](bearframework.app.addonsrepository.class.md) $addons

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides a way to enable addons and manage their options.

##### public readonly [BearFramework\App\Assets](bearframework.app.assets.class.md) $assets

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides utility functions for assets.

##### public readonly [BearFramework\App\CacheRepository](bearframework.app.cacherepository.class.md) $cache

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Data cache.

##### public readonly [BearFramework\App\ClassesRepository](bearframework.app.classesrepository.class.md) $classes

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides functionality for registering and autoloading classes.

##### public readonly [BearFramework\App\ContextsRepository](bearframework.app.contextsrepository.class.md) $contexts

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides information about your code context (the directory its located).

##### public readonly [BearFramework\App\DataRepository](bearframework.app.datarepository.class.md) $data

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A file-based data storage.

##### public readonly [BearFramework\App\LogsRepository](bearframework.app.logsrepository.class.md) $logs

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides logging functionality.

##### public readonly [BearFramework\App\Request](bearframework.app.request.class.md) $request

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides information about the current request.

##### public readonly [BearFramework\App\RoutesRepository](bearframework.app.routesrepository.class.md) $routes

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores the data about the defined routes callbacks.

##### public readonly [BearFramework\App\ShortcutsRepository](bearframework.app.shortcutsrepository.class.md) $shortcuts

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Allow registration of $app object properties (shortcuts).

##### public readonly [BearFramework\App\Urls](bearframework.app.urls.class.md) $urls

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;URLs utilities.

## Methods

##### public [__construct](bearframework.app.__construct.method.md) ( void )

##### public void [addEventListener](bearframework.app.addeventlistener.method.md) ( string $name , callable $listener )

##### protected self [defineProperty](bearframework.app.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property.

##### public void [dispatchEvent](bearframework.app.dispatchevent.method.md) ( [BearFramework\App\Event](bearframework.app.event.class.md) $event )

##### public void [enableErrorHandler](bearframework.app.enableerrorhandler.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enables an error handler.

##### public static [BearFramework\App](bearframework.app.class.md) [get](bearframework.app.get.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the application instance.

##### public bool [hasEventListeners](bearframework.app.haseventlisteners.method.md) ( string $name )

##### public void [removeEventListener](bearframework.app.removeeventlistener.method.md) ( string $name , callable $listener )

##### public void [run](bearframework.app.run.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Call this method to find the response in the registered routes and send it.

##### public void [send](bearframework.app.send.method.md) ( [BearFramework\App\Response](bearframework.app.response.class.md) $response )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Outputs a response.

## Events

##### [Bearframework\App\BeforeSendResponseEvent](bearframework.app.beforesendresponseevent.class.md) beforeSendResponse

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the response is sent to the client.

##### [BearFramework\App\SendResponseEvent](bearframework.app.sendresponseevent.class.md) sendResponse

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the response is sent to the client.

## Details

Location: ~/src/App.php

---

[back to index](index.md)

