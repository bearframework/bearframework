# BearFramework\App\Response\CookiesRepository

Provides information about the response cookies

## Methods

##### public self [delete](bearframework.app.response.cookiesrepository.delete.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a cookie if exists.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public bool [exists](bearframework.app.response.cookiesrepository.exists.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether a cookie with the name specified exists.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: TRUE if a cookie with the name specified exists, FALSE otherwise.

##### public [BearFramework\App\Response\Cookie](bearframework.app.response.cookie.class.md)|null [get](bearframework.app.response.cookiesrepository.get.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a cookie or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The cookie requested of null if not found.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\Response\Cookie[]](bearframework.app.response.cookie.class.md) [getList](bearframework.app.response.cookiesrepository.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all cookies.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: An array containing all cookies.

##### public [BearFramework\App\Response\Cookie](bearframework.app.response.cookie.class.md) [make](bearframework.app.response.cookiesrepository.make.method.md) ( [ string $name [, string $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new cookie and returns it.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a new cookie.

##### public self [set](bearframework.app.response.cookiesrepository.set.method.md) ( [BearFramework\App\Response\Cookie](bearframework.app.response.cookie.class.md) $cookie )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a cookie.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

## Details

File: /src/App/Response/CookiesRepository.php

---

[back to index](index.md)

