# BearFramework\App

The is the class used to instantiate and configure you application.

## Properties

##### public readonly [BearFramework\App\AddonsRepository](bearframework.app.addonsrepository.class.md) $addons

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides a way to enable addons and manage their options.

##### public readonly [BearFramework\App\Assets](bearframework.app.assets.class.md) $assets

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides utility functions for assets.

##### public readonly [BearFramework\App\CacheRepository](bearframework.app.cacherepository.class.md) $cache

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Data cache.

##### public readonly [BearFramework\App\ClassesRepository](bearframework.app.classesrepository.class.md) $classes

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides functionality for registering and autoloading classes.

##### public readonly [BearFramework\App\Config](bearframework.app.config.class.md) $config

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The application configuration.

##### public readonly [BearFramework\App\ContextsRepository](bearframework.app.contextsrepository.class.md) $context

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

##### public void [dispatchEvent](bearframework.app.dispatchevent.method.md) ( [BearFramework\App\Event](bearframework.app.event.class.md) $event )

##### public void [enableErrorHandler](bearframework.app.enableerrorhandler.method.md) ( array $options )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enables an error handler.

##### public static [BearFramework\App](bearframework.app.class.md) [get](bearframework.app.get.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the application instance.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The application instance.

##### public bool [hasEventListeners](bearframework.app.haseventlisteners.method.md) ( string $name )

##### public void [removeEventListener](bearframework.app.removeeventlistener.method.md) ( string $name , callable $listener )

##### public void [run](bearframework.app.run.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Call this method to find the response in the registered routes and send it.

##### public void [send](bearframework.app.send.method.md) ( [BearFramework\App\Response](bearframework.app.response.class.md) $response )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Outputs a response.

##### protected object [defineProperty](bearframework.app.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to the object.

## Events

##### beforeSendResponse

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [Bearframework\App\BeforeSendResponseEvent](bearframework.app.beforesendresponseevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the response is sent to the client.

##### sendResponse

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\SendResponseEvent](bearframework.app.sendresponseevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the response is sent to the client.

## Details

File: /src/App.php

---

[back to index](index.md)

