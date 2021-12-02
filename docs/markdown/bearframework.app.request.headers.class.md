# BearFramework\App\Request\Headers

Provides information about the request headers

```php
BearFramework\App\Request\Headers {

	/* Methods */
	public self delete ( string $name )
	public self deleteAll ( void )
	public bool exists ( string $name )
	public BearFramework\App\Request\Header|null get ( string $name )
	public BearFramework\DataList|BearFramework\App\Request\Header[] getList ( void )
	public string|null getValue ( string $name )
	public BearFramework\App\Request\Header make ( [ string|null $name [, string|null $value ]] )
	public self set ( BearFramework\App\Request\Header $header )

}
```

## Methods

##### public self [delete](bearframework.app.request.headers.delete.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a header if exists.

##### public self [deleteAll](bearframework.app.request.headers.deleteall.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes all headers.

##### public bool [exists](bearframework.app.request.headers.exists.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether a header with the name specified exists.

##### public [BearFramework\App\Request\Header](bearframework.app.request.header.class.md)|null [get](bearframework.app.request.headers.get.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a header or null if not found.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\Request\Header[]](bearframework.app.request.header.class.md) [getList](bearframework.app.request.headers.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all headers.

##### public string|null [getValue](bearframework.app.request.headers.getvalue.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value of the header or null if not found.

##### public [BearFramework\App\Request\Header](bearframework.app.request.header.class.md) [make](bearframework.app.request.headers.make.method.md) ( [ string|null $name [, string|null $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new header and returns it.

##### public self [set](bearframework.app.request.headers.set.method.md) ( [BearFramework\App\Request\Header](bearframework.app.request.header.class.md) $header )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a header.

## Details

Location: ~/src/App/Request/Headers.php

---

[back to index](index.md)

