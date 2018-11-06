# BearFramework\App\AddonsRepository

Provides a way to enable addons.

## Methods

##### public self [add](bearframework.app.addonsrepository.add.method.md) ( string $id )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enables an addon.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public bool [exists](bearframework.app.addonsrepository.exists.method.md) ( string $id )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether an addon with the id specified is enabled.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: TRUE if an addon with the name specified is enabled, FALSE otherwise.

##### public [BearFramework\App\Addon](bearframework.app.addon.class.md)|null [get](bearframework.app.addonsrepository.get.method.md) ( string $id )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the enabled addon or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The enabled addon or null if not found.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\Addon[]](bearframework.app.addon.class.md) [getList](bearframework.app.addonsrepository.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all enabled addons.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: An array containing all enabled addons.

## Details

File: /src/App/AddonsRepository.php

---

[back to index](index.md)

