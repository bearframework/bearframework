# BearFramework\App\Request\HeadersRepository

Provides information about the request headers

```php
BearFramework\App\Request\HeadersRepository {

	/* Methods */
	public self delete ( string $name )
	public bool exists ( string $name )
	public BearFramework\App\Request\Header|null get ( string $name )
	public BearFramework\DataList|BearFramework\App\Request\Header[] getList ( void )
	public string|null getValue ( string $name )
	public BearFramework\App\Request\Header make ( [ string $name [, string $value ]] )
	public self set ( BearFramework\App\Request\Header $header )

}
```

## Methods

##### public self [delete](bearframework.app.request.headersrepository.delete.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a header if exists.

##### public bool [exists](bearframework.app.request.headersrepository.exists.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether a header with the name specified exists.

##### public [BearFramework\App\Request\Header](bearframework.app.request.header.class.md)|null [get](bearframework.app.request.headersrepository.get.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a header or null if not found.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\Request\Header[]](bearframework.app.request.header.class.md) [getList](bearframework.app.request.headersrepository.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all headers.

##### public string|null [getValue](bearframework.app.request.headersrepository.getvalue.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value of the header or null if not found.

##### public [BearFramework\App\Request\Header](bearframework.app.request.header.class.md) [make](bearframework.app.request.headersrepository.make.method.md) ( [ string $name [, string $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new header and returns it.

##### public self [set](bearframework.app.request.headersrepository.set.method.md) ( [BearFramework\App\Request\Header](bearframework.app.request.header.class.md) $header )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a header.

## Details

Location: ~/src/App/Request/HeadersRepository.php

---

[back to index](index.md)

