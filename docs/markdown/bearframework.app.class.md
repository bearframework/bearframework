# BearFramework\App

The is the class used to instantiate you application.

```php
BearFramework\App {

	/* Properties */
	public readonly BearFramework\App\Addons $addons
	public readonly BearFramework\App\Assets $assets
	public readonly BearFramework\App\CacheRepository $cache
	public readonly BearFramework\App\Classes $classes
	public readonly BearFramework\App\Contexts $contexts
	public readonly BearFramework\App\DataRepository $data
	public readonly BearFramework\App\Logs $logs
	public BearFramework\App\Request $request
	public readonly BearFramework\App\Routes $routes
	public readonly BearFramework\App\Shortcuts $shortcuts
	public readonly BearFramework\App\URLs $urls

	/* Methods */
	public __construct ( void )
	public self addEventListener ( string $name , callable $listener )
	public self dispatchEvent ( string $name [, mixed $details [, array $options = [] ]] )
	public void enableErrorHandler ( [ array $options = [] ] )
	public static BearFramework\App get ( void )
	public bool hasEventListeners ( string $name )
	public self removeEventListener ( string $name , callable $listener )
	public void run ( void )
	public void send ( BearFramework\App\Response $response )

}
```

## Properties

##### public readonly [BearFramework\App\Addons](bearframework.app.addons.class.md) $addons

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides a way to enable addons and manage their options.

##### public readonly [BearFramework\App\Assets](bearframework.app.assets.class.md) $assets

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides utility functions for assets.

##### public readonly [BearFramework\App\CacheRepository](bearframework.app.cacherepository.class.md) $cache

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Data cache.

##### public readonly [BearFramework\App\Classes](bearframework.app.classes.class.md) $classes

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides functionality for registering and autoloading classes.

##### public readonly [BearFramework\App\Contexts](bearframework.app.contexts.class.md) $contexts

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides information about your code context (the directory its located).

##### public readonly [BearFramework\App\DataRepository](bearframework.app.datarepository.class.md) $data

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A file-based data storage.

##### public readonly [BearFramework\App\Logs](bearframework.app.logs.class.md) $logs

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides logging functionality.

##### public [BearFramework\App\Request](bearframework.app.request.class.md) $request

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides information about the current request.

##### public readonly [BearFramework\App\Routes](bearframework.app.routes.class.md) $routes

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores the data about the defined routes callbacks.

##### public readonly [BearFramework\App\Shortcuts](bearframework.app.shortcuts.class.md) $shortcuts

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Allow registration of $app object properties (shortcuts).

##### public readonly [BearFramework\App\URLs](bearframework.app.urls.class.md) $urls

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;URLs utilities.

## Methods

##### public [__construct](bearframework.app.__construct.method.md) ( void )

##### public self [addEventListener](bearframework.app.addeventlistener.method.md) ( string $name , callable $listener )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers a new event listener.

##### public self [dispatchEvent](bearframework.app.dispatchevent.method.md) ( string $name [, mixed $details [, array $options = [] ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Calls the registered listeners (in order) for the event name specified.

##### public void [enableErrorHandler](bearframework.app.enableerrorhandler.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enables an error handler.

##### public static [BearFramework\App](bearframework.app.class.md) [get](bearframework.app.get.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the application instance.

##### public bool [hasEventListeners](bearframework.app.haseventlisteners.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns TRUE if there are registered event listeners for the name specified, FALSE otherwise.

##### public self [removeEventListener](bearframework.app.removeeventlistener.method.md) ( string $name , callable $listener )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Removes a registered event listener.

##### public void [run](bearframework.app.run.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Call this method to find the response in the registered routes and send it.

##### public void [send](bearframework.app.send.method.md) ( [BearFramework\App\Response](bearframework.app.response.class.md) $response )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Outputs a response.

## Events

##### [Bearframework\App\BeforeSendResponseEventDetails](bearframework.app.beforesendresponseeventdetails.class.md) beforeSendResponse

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the response is sent to the client.

##### [BearFramework\App\SendResponseEventDetails](bearframework.app.sendresponseeventdetails.class.md) sendResponse

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the response is sent to the client.

## Details

Location: ~/src/App.php

---

[back to index](index.md)

