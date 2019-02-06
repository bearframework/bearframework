# BearFramework\App\Request

Provides information about the current request.

```php
BearFramework\App\Request {

	/* Properties */
	public string|null $base
	public readonly BearFramework\App\Request\CookiesRepository $cookies
	public readonly BearFramework\App\Request\FormDataRepository $formData
	public readonly BearFramework\App\Request\HeadersRepository $headers
	public string|null $host
	public string|null $method
	public readonly BearFramework\App\Request\PathRepository $path
	public int|null $port
	public readonly BearFramework\App\Request\QueryRepository $query
	public string|null $scheme

	/* Methods */
	public __construct ( [ bool $initializeFromEnvironment = false ] )

}
```

## Properties

##### public string|null $base

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The base URL of the request.

##### public readonly [BearFramework\App\Request\CookiesRepository](bearframework.app.request.cookiesrepository.class.md) $cookies

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request cookies.

##### public readonly [BearFramework\App\Request\FormDataRepository](bearframework.app.request.formdatarepository.class.md) $formData

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request POST data and files.

##### public readonly [BearFramework\App\Request\HeadersRepository](bearframework.app.request.headersrepository.class.md) $headers

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request headers.

##### public string|null $host

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request hostname.

##### public string|null $method

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request method.

##### public readonly [BearFramework\App\Request\PathRepository](bearframework.app.request.pathrepository.class.md) $path

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request path.

##### public int|null $port

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request port.

##### public readonly [BearFramework\App\Request\QueryRepository](bearframework.app.request.queryrepository.class.md) $query

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request query string.

##### public string|null $scheme

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request scheme.

## Methods

##### public [__construct](bearframework.app.request.__construct.method.md) ( [ bool $initializeFromEnvironment = false ] )

## Details

Location: ~/src/App/Request.php

---

[back to index](index.md)

