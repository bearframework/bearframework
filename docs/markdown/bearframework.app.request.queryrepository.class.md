# BearFramework\App\Request\QueryRepository

Provides information about the response query items

## Methods

##### public self [delete](bearframework.app.request.queryrepository.delete.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a query item if exists.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public bool [exists](bearframework.app.request.queryrepository.exists.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether a query item with the name specified exists.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: TRUE if a query item with the name specified exists, FALSE otherwise.

##### public [BearFramework\App\Request\QueryItem](bearframework.app.request.queryitem.class.md)|null [get](bearframework.app.request.queryrepository.get.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a query item or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The query item requested of null if not found.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\Request\QueryItem[]](bearframework.app.request.queryitem.class.md) [getList](bearframework.app.request.queryrepository.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all query items.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: An array containing all query items.

##### public string|null [getValue](bearframework.app.request.queryrepository.getvalue.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a query item value or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The query item value requested of null if not found.

##### public [BearFramework\App\Request\QueryItem](bearframework.app.request.queryitem.class.md) [make](bearframework.app.request.queryrepository.make.method.md) ( [ string $name [, string $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new query item and returns it.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a new query item.

##### public self [set](bearframework.app.request.queryrepository.set.method.md) ( [BearFramework\App\Request\QueryItem](bearframework.app.request.queryitem.class.md) $queryItem )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a query item.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public string [toString](bearframework.app.request.queryrepository.tostring.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the query items as string.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns the query items as string.

## Details

File: /src/App/Request/QueryRepository.php

---

[back to index](index.md)

