# BearFramework\App\Response\HeadersRepository

A repository for the response headers.

```php
BearFramework\App\Response\HeadersRepository {

	/* Methods */
	public self delete ( string $name )
	public bool exists ( string $name )
	public BearFramework\App\Response\Header|null get ( string $name )
	public BearFramework\DataList|BearFramework\App\Response\Header[] getList ( void )
	public string|null getValue ( string $name )
	public BearFramework\App\Response\Header make ( [ string $name [, string $value ]] )
	public self set ( BearFramework\App\Response\Header $header )

}
```

## Methods

##### public self [delete](bearframework.app.response.headersrepository.delete.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a header if exists.

##### public bool [exists](bearframework.app.response.headersrepository.exists.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether a header with the name specified exists.

##### public [BearFramework\App\Response\Header](bearframework.app.response.header.class.md)|null [get](bearframework.app.response.headersrepository.get.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a header or null if not found.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\Response\Header[]](bearframework.app.response.header.class.md) [getList](bearframework.app.response.headersrepository.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all headers.

##### public string|null [getValue](bearframework.app.response.headersrepository.getvalue.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value of the header or null if not found.

##### public [BearFramework\App\Response\Header](bearframework.app.response.header.class.md) [make](bearframework.app.response.headersrepository.make.method.md) ( [ string $name [, string $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new header and returns it.

##### public self [set](bearframework.app.response.headersrepository.set.method.md) ( [BearFramework\App\Response\Header](bearframework.app.response.header.class.md) $header )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a header.

## Details

Location: ~/src/App/Response/HeadersRepository.php

---

[back to index](index.md)

