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
	public self dispatchEvent ( string $name [, mixed $details ] )
	public string|null getContent ( string $filename [, array $options = [] ] )
	public array getDetails ( string $filename , array $list )
	public BearFramework\App\Response|null getResponse ( BearFramework\App\Request $request )
	public string getURL ( string $filename [, array $options = [] ] )
	public bool hasEventListeners ( string $name )
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

##### public self [dispatchEvent](bearframework.app.assets.dispatchevent.method.md) ( string $name [, mixed $details ] )

##### public string|null [getContent](bearframework.app.assets.getcontent.method.md) ( string $filename [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the content of the file specified.

##### public array [getDetails](bearframework.app.assets.getdetails.method.md) ( string $filename , array $list )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of details for the filename specified.

##### public [BearFramework\App\Response](bearframework.app.response.class.md)|null [getResponse](bearframework.app.assets.getresponse.method.md) ( [BearFramework\App\Request](bearframework.app.request.class.md) $request )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates a response object for the asset request.

##### public string [getURL](bearframework.app.assets.geturl.method.md) ( string $filename [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a public URL for the specified filename.

##### public bool [hasEventListeners](bearframework.app.assets.haseventlisteners.method.md) ( string $name )

##### public self [removeEventListener](bearframework.app.assets.removeeventlistener.method.md) ( string $name , callable $listener )

## Events

##### BearFramework\App\Assets\BeforeGetDetailsEvent beforeGetDetails

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the details of the asset specified is created.

##### BearFramework\App\Assets\BeforeGetURLEvent beforeGetURL

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the URL of the asset specified is created.

##### BearFramework\App\Assets\BeforePrepareEvent beforePrepare

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the asset specified is prepared for returning (resized for example).

##### BearFramework\App\Assets\GetDetailsEvent getDetails

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the details of the asset specified is created.

##### BearFramework\App\Assets\GetURLEvent getURL

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the URL of the asset specified is created.

##### BearFramework\App\Assets\PrepareEvent prepare

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the asset specified is prepared for returning (resized for example)

## Details

Location: ~/src/App/Assets.php

---

[back to index](index.md)

