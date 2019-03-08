# BearFramework\App\Addons

Provides a way to enable addons.

```php
BearFramework\App\Addons {

	/* Methods */
	public __construct ( BearFramework\App $app )
	public self add ( string $id )
	public bool exists ( string $id )
	public BearFramework\App\Addon|null get ( string $id )
	public BearFramework\DataList|BearFramework\App\Addon[] getList ( void )

}
```

## Methods

##### public [__construct](bearframework.app.addons.__construct.method.md) ( [BearFramework\App](bearframework.app.class.md) $app )

##### public self [add](bearframework.app.addons.add.method.md) ( string $id )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enables an addon.

##### public bool [exists](bearframework.app.addons.exists.method.md) ( string $id )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether an addon with the id specified is enabled.

##### public [BearFramework\App\Addon](bearframework.app.addon.class.md)|null [get](bearframework.app.addons.get.method.md) ( string $id )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the enabled addon or null if not found.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\Addon[]](bearframework.app.addon.class.md) [getList](bearframework.app.addons.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all enabled addons.

## Details

Location: ~/src/App/Addons.php

---

[back to index](index.md)

