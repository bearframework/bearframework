# BearFramework\App\Response\Cookies

Provides information about the response cookies

```php
BearFramework\App\Response\Cookies {

	/* Methods */
	public self delete ( string $name )
	public self deleteAll ( void )
	public bool exists ( string $name )
	public BearFramework\App\Response\Cookie|null get ( string $name )
	public BearFramework\DataList|BearFramework\App\Response\Cookie[] getList ( void )
	public BearFramework\App\Response\Cookie make ( [ string|null $name [, string|null $value ]] )
	public self set ( BearFramework\App\Response\Cookie $cookie )

}
```

## Methods

##### public self [delete](bearframework.app.response.cookies.delete.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a cookie if exists.

##### public self [deleteAll](bearframework.app.response.cookies.deleteall.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes all cookies.

##### public bool [exists](bearframework.app.response.cookies.exists.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether a cookie with the name specified exists.

##### public [BearFramework\App\Response\Cookie](bearframework.app.response.cookie.class.md)|null [get](bearframework.app.response.cookies.get.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a cookie or null if not found.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\Response\Cookie[]](bearframework.app.response.cookie.class.md) [getList](bearframework.app.response.cookies.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all cookies.

##### public [BearFramework\App\Response\Cookie](bearframework.app.response.cookie.class.md) [make](bearframework.app.response.cookies.make.method.md) ( [ string|null $name [, string|null $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new cookie and returns it.

##### public self [set](bearframework.app.response.cookies.set.method.md) ( [BearFramework\App\Response\Cookie](bearframework.app.response.cookie.class.md) $cookie )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a cookie.

## Details

Location: ~/src/App/Response/Cookies.php

---

[back to index](index.md)

