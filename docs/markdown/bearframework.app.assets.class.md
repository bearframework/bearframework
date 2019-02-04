# BearFramework\App\Assets

Provides utility functions for assets.

```php
BearFramework\App\Assets {

	/* Properties */
	public readonly string $pathPrefix

	/* Methods */
	public __construct ( BearFramework\App $app )
	public self addDir ( string $pathname )
	public void addEventListener ( string $name , callable $listener )
	protected self defineProperty ( string $name [, array $options = [] ] )
	public void dispatchEvent ( BearFramework\App\Event $event )
	public string|null getContent ( string $filename [, array $options = [] ] )
	public array getDetails ( string $filename , array $list )
	public BearFramework\App\Response|null getResponse ( BearFramework\App\Request $request )
	public string getUrl ( string $filename [, array $options = [] ] )
	public bool hasEventListeners ( string $name )
	public void removeEventListener ( string $name , callable $listener )

}
```

## Properties

##### public readonly string $pathPrefix

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The prefix of the assets URLs.

## Methods

##### public [__construct](bearframework.app.assets.__construct.method.md) ( [BearFramework\App](bearframework.app.class.md) $app )

##### public self [addDir](bearframework.app.assets.adddir.method.md) ( string $pathname )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers a directory that will be publicly accessible.

##### public void [addEventListener](bearframework.app.assets.addeventlistener.method.md) ( string $name , callable $listener )

##### protected self [defineProperty](bearframework.app.assets.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property.

##### public void [dispatchEvent](bearframework.app.assets.dispatchevent.method.md) ( [BearFramework\App\Event](bearframework.app.event.class.md) $event )

##### public string|null [getContent](bearframework.app.assets.getcontent.method.md) ( string $filename [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the content of the file specified.

##### public array [getDetails](bearframework.app.assets.getdetails.method.md) ( string $filename , array $list )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of details for the filename specified.

##### public [BearFramework\App\Response](bearframework.app.response.class.md)|null [getResponse](bearframework.app.assets.getresponse.method.md) ( [BearFramework\App\Request](bearframework.app.request.class.md) $request )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates a response object for the asset request.

##### public string [getUrl](bearframework.app.assets.geturl.method.md) ( string $filename [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a public URL for the specified filename.

##### public bool [hasEventListeners](bearframework.app.assets.haseventlisteners.method.md) ( string $name )

##### public void [removeEventListener](bearframework.app.assets.removeeventlistener.method.md) ( string $name , callable $listener )

## Events

##### [BearFramework\App\Assets\BeforeGetDetailsEvent](bearframework.app.assets.beforegetdetailsevent.class.md) beforeGetDetails

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the details of the asset specified is created.

##### [BearFramework\App\Assets\BeforeGetUrlEvent](bearframework.app.assets.beforegeturlevent.class.md) beforeGetUrl

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the URL of the asset specified is created.

##### [BearFramework\App\Assets\BeforePrepareEvent](bearframework.app.assets.beforeprepareevent.class.md) beforePrepare

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the asset specified is prepared for returning (resized for example).

##### [BearFramework\App\Assets\GetDetailsEvent](bearframework.app.assets.getdetailsevent.class.md) getDetails

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the details of the asset specified is created.

##### [BearFramework\App\Assets\GetUrlEvent](bearframework.app.assets.geturlevent.class.md) getUrl

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the URL of the asset specified is created.

##### [BearFramework\App\Assets\PrepareEvent](bearframework.app.assets.prepareevent.class.md) prepare

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the asset specified is prepared for returning (resized for example)

## Details

Location: ~/src/App/Assets.php

---

[back to index](index.md)

