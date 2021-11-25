# BearFramework\App\Request\Query

Provides information about the response query items

```php
BearFramework\App\Request\Query implements Stringable {

	/* Methods */
	public self delete ( string $name )
	public bool exists ( string $name )
	public BearFramework\App\Request\QueryItem|null get ( string $name )
	public BearFramework\DataList|BearFramework\App\Request\QueryItem[] getList ( void )
	public string|null getValue ( string $name )
	public BearFramework\App\Request\QueryItem make ( [ string|null $name [, string|null $value ]] )
	public self set ( BearFramework\App\Request\QueryItem $queryItem )
	public string toString ( void )

}
```

## Implements

##### [Stringable](http://php.net/manual/en/class.stringable.php)

## Methods

##### public self [delete](bearframework.app.request.query.delete.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a query item if exists.

##### public bool [exists](bearframework.app.request.query.exists.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether a query item with the name specified exists.

##### public [BearFramework\App\Request\QueryItem](bearframework.app.request.queryitem.class.md)|null [get](bearframework.app.request.query.get.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a query item or null if not found.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\Request\QueryItem[]](bearframework.app.request.queryitem.class.md) [getList](bearframework.app.request.query.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all query items.

##### public string|null [getValue](bearframework.app.request.query.getvalue.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a query item value or null if not found.

##### public [BearFramework\App\Request\QueryItem](bearframework.app.request.queryitem.class.md) [make](bearframework.app.request.query.make.method.md) ( [ string|null $name [, string|null $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new query item and returns it.

##### public self [set](bearframework.app.request.query.set.method.md) ( [BearFramework\App\Request\QueryItem](bearframework.app.request.queryitem.class.md) $queryItem )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a query item.

##### public string [toString](bearframework.app.request.query.tostring.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the query items as string.

## Details

Location: ~/src/App/Request/Query.php

---

[back to index](index.md)

