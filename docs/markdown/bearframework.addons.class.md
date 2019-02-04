# BearFramework\Addons

The place to register addons that can be enabled for the application.

```php
BearFramework\Addons {

	/* Methods */
	public static bool exists ( string $id )
	public static BearFramework\Addon|null get ( string $id )
	public static BearFramework\DataList|BearFramework\Addon[] getList ( void )
	public static bool register ( string $id , string $dir [, array $options = [] ] )

}
```

## Methods

##### public static bool [exists](bearframework.addons.exists.method.md) ( string $id )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checks whether an addon is registered.

##### public static [BearFramework\Addon](bearframework.addon.class.md)|null [get](bearframework.addons.get.method.md) ( string $id )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information about the addon specified.

##### public static [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\Addon[]](bearframework.addon.class.md) [getList](bearframework.addons.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all registered addons.

##### public static bool [register](bearframework.addons.register.method.md) ( string $id , string $dir [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers an addon.

## Details

Location: ~/src/Addons.php

---

[back to index](index.md)

