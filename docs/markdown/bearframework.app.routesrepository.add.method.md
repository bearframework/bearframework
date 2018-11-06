# BearFramework\App\RoutesRepository::add

Registers a request handler.

```php
public self add ( string|string[] $pattern , callable|callable[] $callback [, array $options = ["GET"] ] )
```

## Parameters

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$pattern`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Path pattern. Can contain "?" (path segment) and "*" (matches everything).

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$callback`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Function that is expected to return object of type \BearFramework\App\Response.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$options`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Matching options for methods (GET, HEAD, POST, DELETE, PUT, PATCH, OPTIONS) and protocols (HTTP, HTTPS).

## Returns

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns Returns a reference to itself.

## Details

Class: [BearFramework\App\RoutesRepository](bearframework.app.routesrepository.class.md)

File: /src/App/RoutesRepository.php

---

[back to index](index.md)

