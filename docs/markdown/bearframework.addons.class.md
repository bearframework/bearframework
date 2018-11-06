# BearFramework\Addons

The place to register addons that can be enabled for the application.

## Methods

##### public static bool [exists](bearframework.addons.exists.method.md) ( string $id )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checks whether an addon is registered.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: TRUE if the addon is registered. FALSE otherwise.

##### public static [BearFramework\Addon](bearframework.addon.class.md)|null [get](bearframework.addons.get.method.md) ( string $id )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information about the addon specified.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Information about the addon requested or null if not found.

##### public static [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\Addon[]](bearframework.addon.class.md) [getList](bearframework.addons.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all registered addons.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: A list of all registered addons.

##### public static bool [register](bearframework.addons.register.method.md) ( string $id , string $dir [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers an addon.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: TRUE if successfully registered. FALSE otherwise.

## Details

File: /src/Addons.php

---

[back to index](index.md)

