# BearFramework\App\Assets

Provides utility functions for assets.

```php
BearFramework\App\Assets {

	/* Properties */
	public readonly string $pathPrefix

	/* Methods */
	public __construct ( BearFramework\App $app )
	public self addDir ( string $pathname )
	public self addEventListener ( string $name , callable $listener )
	public self dispatchEvent ( string $name [, mixed $details [, array $options = [] ]] )
	public string|null getContent ( string $filename [, array $options = [] ] )
	public array getDetails ( string $filename , array $list )
	public BearFramework\App\Response|null getResponse ( BearFramework\App\Request $request )
	public array getSupportedOutputTypes ( void )
	public string getURL ( string $filename [, array $options = [] ] )
	public bool hasEventListeners ( string $name )
	public bool isSupportedOutputType ( string $name )
	public self removeEventListener ( string $name , callable $listener )

}
```

## Properties

##### public readonly string $pathPrefix

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The prefix of the assets URLs.

## Methods

##### public [__construct](bearframework.app.assets.__construct.method.md) ( [BearFramework\App](bearframework.app.class.md) $app )

##### public self [addDir](bearframework.app.assets.adddir.method.md) ( string $pathname )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers a directory that will be publicly accessible.

##### public self [addEventListener](bearframework.app.assets.addeventlistener.method.md) ( string $name , callable $listener )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers a new event listener.

##### public self [dispatchEvent](bearframework.app.assets.dispatchevent.method.md) ( string $name [, mixed $details [, array $options = [] ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Calls the registered listeners (in order) for the event name specified.

##### public string|null [getContent](bearframework.app.assets.getcontent.method.md) ( string $filename [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the content of the file specified.

##### public array [getDetails](bearframework.app.assets.getdetails.method.md) ( string $filename , array $list )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of details for the filename specified.

##### public [BearFramework\App\Response](bearframework.app.response.class.md)|null [getResponse](bearframework.app.assets.getresponse.method.md) ( [BearFramework\App\Request](bearframework.app.request.class.md) $request )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates a response object for the asset request.

##### public array [getSupportedOutputTypes](bearframework.app.assets.getsupportedoutputtypes.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of supported output types (that can be converted to).

##### public string [getURL](bearframework.app.assets.geturl.method.md) ( string $filename [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a public URL for the specified filename.

##### public bool [hasEventListeners](bearframework.app.assets.haseventlisteners.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns TRUE if there are registered event listeners for the name specified, FALSE otherwise.

##### public bool [isSupportedOutputType](bearframework.app.assets.issupportedoutputtype.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns TRUE if the output type specified is supported.

##### public self [removeEventListener](bearframework.app.assets.removeeventlistener.method.md) ( string $name , callable $listener )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Removes a registered event listener.

## Events

##### [BearFramework\App\Assets\BeforeGetContentEventDetails](bearframework.app.assets.beforegetcontenteventdetails.class.md) beforeGetContent

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the content of the asset specified is constructed.

##### [BearFramework\App\Assets\BeforeGetDetailsEventDetails](bearframework.app.assets.beforegetdetailseventdetails.class.md) beforeGetDetails

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the details of the asset specified is created.

##### [BearFramework\App\Assets\BeforeGetURLEventDetails](bearframework.app.assets.beforegeturleventdetails.class.md) beforeGetURL

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the URL of the asset specified is created.

##### [BearFramework\App\Assets\BeforePrepareEventDetails](bearframework.app.assets.beforeprepareeventdetails.class.md) beforePrepare

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the asset specified is prepared for returning (resized for example).

##### [BearFramework\App\Assets\GetContentEventDetails](bearframework.app.assets.getcontenteventdetails.class.md) getContent

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the content of the asset specified is constructed.

##### [BearFramework\App\Assets\GetDetailsEventDetails](bearframework.app.assets.getdetailseventdetails.class.md) getDetails

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the details of the asset specified is created.

##### [BearFramework\App\Assets\GetURLEventDetails](bearframework.app.assets.geturleventdetails.class.md) getURL

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the URL of the asset specified is created.

##### [BearFramework\App\Assets\PrepareEventDetails](bearframework.app.assets.prepareeventdetails.class.md) prepare

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the asset specified is prepared for returning (resized for example)

## Details

Location: ~/src/App/Assets.php

---

[back to index](index.md)

