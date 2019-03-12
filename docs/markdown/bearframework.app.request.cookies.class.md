# BearFramework\App\Request\Cookies

Provides information about the response cookies

```php
BearFramework\App\Request\Cookies {

	/* Methods */
	public self delete ( string $name )
	public bool exists ( string $name )
	public BearFramework\App\Request\Cookie|null get ( string $name )
	public BearFramework\DataList|BearFramework\App\Request\Cookie[] getList ( void )
	public string|null getValue ( string $name )
	public BearFramework\App\Request\Cookie make ( [ string|null $name [, string|null $value ]] )
	public self set ( BearFramework\App\Request\Cookie $cookie )

}
```

## Methods

##### public self [delete](bearframework.app.request.cookies.delete.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a cookie if exists.

##### public bool [exists](bearframework.app.request.cookies.exists.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether a cookie with the name specified exists.

##### public [BearFramework\App\Request\Cookie](bearframework.app.request.cookie.class.md)|null [get](bearframework.app.request.cookies.get.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a cookie or null if not found.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\Request\Cookie[]](bearframework.app.request.cookie.class.md) [getList](bearframework.app.request.cookies.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all cookies.

##### public string|null [getValue](bearframework.app.request.cookies.getvalue.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a cookie value or null if not found.

##### public [BearFramework\App\Request\Cookie](bearframework.app.request.cookie.class.md) [make](bearframework.app.request.cookies.make.method.md) ( [ string|null $name [, string|null $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new cookie and returns it.

##### public self [set](bearframework.app.request.cookies.set.method.md) ( [BearFramework\App\Request\Cookie](bearframework.app.request.cookie.class.md) $cookie )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a cookie.

## Details

Location: ~/src/App/Request/Cookies.php

---

[back to index](index.md)

