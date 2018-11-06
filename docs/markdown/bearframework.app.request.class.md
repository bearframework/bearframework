# BearFramework\App\Request

Provides information about the current request.

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

##### public array [toArray](bearframework.app.request.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The object data converted as an array.

##### public string [toJSON](bearframework.app.request.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The object data converted as JSON.

##### protected object [defineProperty](bearframework.app.request.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to the object.

## Details

File: /src/App/Request.php

---

[back to index](index.md)

