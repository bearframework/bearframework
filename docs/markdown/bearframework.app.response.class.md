# BearFramework\App\Response

Response object.

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

##### public array [toArray](bearframework.app.response.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The object data converted as an array.

##### public string [toJSON](bearframework.app.response.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The object data converted as JSON.

##### protected object [defineProperty](bearframework.app.response.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to the object.

## Details

File: /src/App/Response/FileReader.php

---

[back to index](index.md)

