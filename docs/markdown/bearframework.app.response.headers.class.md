# BearFramework\App\Response\Headers

A repository for the response headers.

```php
BearFramework\App\Response\Headers {

	/* Methods */
	public self delete ( string $name )
	public self deleteAll ( void )
	public bool exists ( string $name )
	public BearFramework\App\Response\Header|null get ( string $name )
	public BearFramework\DataList|BearFramework\App\Response\Header[] getList ( void )
	public string|null getValue ( string $name )
	public BearFramework\App\Response\Header make ( [ string|null $name [, string|null $value ]] )
	public self set ( BearFramework\App\Response\Header $header )

}
```

## Methods

##### public self [delete](bearframework.app.response.headers.delete.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a header if exists.

##### public self [deleteAll](bearframework.app.response.headers.deleteall.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes all headers.

##### public bool [exists](bearframework.app.response.headers.exists.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether a header with the name specified exists.

##### public [BearFramework\App\Response\Header](bearframework.app.response.header.class.md)|null [get](bearframework.app.response.headers.get.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a header or null if not found.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\Response\Header[]](bearframework.app.response.header.class.md) [getList](bearframework.app.response.headers.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all headers.

##### public string|null [getValue](bearframework.app.response.headers.getvalue.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value of the header or null if not found.

##### public [BearFramework\App\Response\Header](bearframework.app.response.header.class.md) [make](bearframework.app.response.headers.make.method.md) ( [ string|null $name [, string|null $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new header and returns it.

##### public self [set](bearframework.app.response.headers.set.method.md) ( [BearFramework\App\Response\Header](bearframework.app.response.header.class.md) $header )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a header.

## Details

Location: ~/src/App/Response/Headers.php

---

[back to index](index.md)

