# BearFramework\App\Request\CookiesRepository

Provides information about the response cookies

## Methods

##### public self [delete](bearframework.app.request.cookiesrepository.delete.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a cookie if exists.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public bool [exists](bearframework.app.request.cookiesrepository.exists.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether a cookie with the name specified exists.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: TRUE if a cookie with the name specified exists, FALSE otherwise.

##### public [BearFramework\App\Request\Cookie](bearframework.app.request.cookie.class.md)|null [get](bearframework.app.request.cookiesrepository.get.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a cookie or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The cookie requested of null if not found.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\Request\Cookie[]](bearframework.app.request.cookie.class.md) [getList](bearframework.app.request.cookiesrepository.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all cookies.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: An array containing all cookies.

##### public string|null [getValue](bearframework.app.request.cookiesrepository.getvalue.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a cookie value or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The cookie value requested of null if not found.

##### public [BearFramework\App\Request\Cookie](bearframework.app.request.cookie.class.md) [make](bearframework.app.request.cookiesrepository.make.method.md) ( [ string $name [, string $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new cookie and returns it.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a new cookie.

##### public self [set](bearframework.app.request.cookiesrepository.set.method.md) ( [BearFramework\App\Request\Cookie](bearframework.app.request.cookie.class.md) $cookie )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a cookie.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

## Details

File: /src/App/Request/CookiesRepository.php

---

[back to index](index.md)

