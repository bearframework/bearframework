# BearFramework\App\Response\CookiesRepository

Provides information about the response cookies

```php
BearFramework\App\Response\CookiesRepository {

	/* Methods */
	public self delete ( string $name )
	public bool exists ( string $name )
	public BearFramework\App\Response\Cookie|null get ( string $name )
	public BearFramework\DataList|BearFramework\App\Response\Cookie[] getList ( void )
	public BearFramework\App\Response\Cookie make ( [ string $name [, string $value ]] )
	public self set ( BearFramework\App\Response\Cookie $cookie )

}
```

## Methods

##### public self [delete](bearframework.app.response.cookiesrepository.delete.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a cookie if exists.

##### public bool [exists](bearframework.app.response.cookiesrepository.exists.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether a cookie with the name specified exists.

##### public [BearFramework\App\Response\Cookie](bearframework.app.response.cookie.class.md)|null [get](bearframework.app.response.cookiesrepository.get.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a cookie or null if not found.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\Response\Cookie[]](bearframework.app.response.cookie.class.md) [getList](bearframework.app.response.cookiesrepository.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all cookies.

##### public [BearFramework\App\Response\Cookie](bearframework.app.response.cookie.class.md) [make](bearframework.app.response.cookiesrepository.make.method.md) ( [ string $name [, string $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new cookie and returns it.

##### public self [set](bearframework.app.response.cookiesrepository.set.method.md) ( [BearFramework\App\Response\Cookie](bearframework.app.response.cookie.class.md) $cookie )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a cookie.

## Details

Location: ~/src/App/Response/CookiesRepository.php

---

[back to index](index.md)

