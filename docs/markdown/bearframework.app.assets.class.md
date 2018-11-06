# BearFramework\App\Assets

Provides utility functions for assets.

## Methods

##### public [__construct](bearframework.app.assets.__construct.method.md) ( void )

##### public self [addDir](bearframework.app.assets.adddir.method.md) ( string $pathname )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers a directory that will be publicly accessible.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public void [addEventListener](bearframework.app.assets.addeventlistener.method.md) ( string $name , callable $listener )

##### public void [dispatchEvent](bearframework.app.assets.dispatchevent.method.md) ( [BearFramework\App\Event](bearframework.app.event.class.md) $event )

##### public string|null [getContent](bearframework.app.assets.getcontent.method.md) ( string $filename [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the content of the file specified.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The content of the file or null if file does not exists.

##### public array [getDetails](bearframework.app.assets.getdetails.method.md) ( string $filename , array $list )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of details for the filename specified.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: A list of tails for the filename specified.

##### public [BearFramework\App\Response](bearframework.app.response.class.md)|null [getResponse](bearframework.app.assets.getresponse.method.md) ( [BearFramework\App\Request](bearframework.app.request.class.md) $request )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates a response object for the asset request.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The response object for the request specified.

##### public string [getUrl](bearframework.app.assets.geturl.method.md) ( string $filename [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a public URL for the specified filename.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The URL for the specified filename and options.

##### public bool [hasEventListeners](bearframework.app.assets.haseventlisteners.method.md) ( string $name )

##### public void [removeEventListener](bearframework.app.assets.removeeventlistener.method.md) ( string $name , callable $listener )

##### public self [setPathPrefix](bearframework.app.assets.setpathprefix.method.md) ( string $pathPrefix )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

## Events

##### beforeGetDetails

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Assets\BeforeGetDetailsEvent](bearframework.app.assets.beforegetdetailsevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the details of the asset specified is created.

##### beforeGetUrl

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Assets\BeforeGetUrlEvent](bearframework.app.assets.beforegeturlevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the URL of the asset specified is created.

##### beforePrepare

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Assets\BeforePrepareEvent](bearframework.app.assets.beforeprepareevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the asset specified is prepared for returning (resized for example).

##### getDetails

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Assets\GetDetailsEvent](bearframework.app.assets.getdetailsevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the details of the asset specified is created.

##### getUrl

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Assets\GetUrlEvent](bearframework.app.assets.geturlevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the URL of the asset specified is created.

##### prepare

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Assets\PrepareEvent](bearframework.app.assets.prepareevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the asset specified is prepared for returning (resized for example)

## Details

File: /src/App/Assets.php

---

[back to index](index.md)

