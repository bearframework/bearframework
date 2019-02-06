# BearFramework\App\Response

Response object.

```php
BearFramework\App\Response {

	/* Properties */
	public string $charset
	public string $content
	public readonly BearFramework\App\Response\CookiesRepository $cookies
	public readonly BearFramework\App\Response\HeadersRepository $headers
	public int|null $statusCode

	/* Methods */
	public __construct ( [ string $content = '' ] )

}
```

## Properties

##### public string $charset

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The response character set.

##### public string $content

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The content of the response.

##### public readonly [BearFramework\App\Response\CookiesRepository](bearframework.app.response.cookiesrepository.class.md) $cookies

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The response cookies.

##### public readonly [BearFramework\App\Response\HeadersRepository](bearframework.app.response.headersrepository.class.md) $headers

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The response headers.

##### public int|null $statusCode

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The response status code.

## Methods

##### public [__construct](bearframework.app.response.__construct.method.md) ( [ string $content = '' ] )

## Details

Location: ~/src/App/Response/FileReader.php

---

[back to index](index.md)

