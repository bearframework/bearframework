# BearFramework\App\Request

Provides information about the current request.

```php
BearFramework\App\Request {

	/* Properties */
	public string|null $base
	public readonly BearFramework\App\Request\Cookies $cookies
	public readonly BearFramework\App\Request\FormData $formData
	public readonly BearFramework\App\Request\Headers $headers
	public string|null $host
	public string|null $method
	public readonly BearFramework\App\Request\Path $path
	public int|null $port
	public readonly BearFramework\App\Request\Query $query
	public string|null $scheme

	/* Methods */
	public __construct ( [ bool $initializeFromEnvironment = false ] )
	public string|null getURL ( void )
	public self setURL ( string $url )

}
```

## Properties

##### public string|null $base

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The base URL of the request.

##### public readonly [BearFramework\App\Request\Cookies](bearframework.app.request.cookies.class.md) $cookies

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request cookies.

##### public readonly [BearFramework\App\Request\FormData](bearframework.app.request.formdata.class.md) $formData

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request POST data and files.

##### public readonly [BearFramework\App\Request\Headers](bearframework.app.request.headers.class.md) $headers

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request headers.

##### public string|null $host

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request hostname.

##### public string|null $method

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request method.

##### public readonly [BearFramework\App\Request\Path](bearframework.app.request.path.class.md) $path

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request path.

##### public int|null $port

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request port.

##### public readonly [BearFramework\App\Request\Query](bearframework.app.request.query.class.md) $query

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request query string.

##### public string|null $scheme

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The request scheme.

## Methods

##### public [__construct](bearframework.app.request.__construct.method.md) ( [ bool $initializeFromEnvironment = false ] )

##### public string|null [getURL](bearframework.app.request.geturl.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the request URL or null if the base is empty.

##### public self [setURL](bearframework.app.request.seturl.method.md) ( string $url )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a new URL and overwrites the base, scheme, host, port, path and query properties.

## Details

Location: ~/src/App/Request.php

---

[back to index](index.md)

