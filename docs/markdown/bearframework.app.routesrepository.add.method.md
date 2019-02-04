# BearFramework\App\RoutesRepository::add

Registers a request handler.

```php
public self add ( string|string[] $pattern , callable|callable[] $callback )
```

## Parameters

##### pattern

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Path pattern or array of patterns. Can contain "?" (path segment) and "*" (matches everything). Can start with method name (GET, HEAD, POST, DELETE, PUT, PATCH, OPTIONS) or list of method names (GET|HEAD|POST).

##### callback

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Function that is expected to return object of type \BearFramework\App\Response.

## Returns

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a reference to itself.

## Details

Class: [BearFramework\App\RoutesRepository](bearframework.app.routesrepository.class.md)

Location: ~/src/App/RoutesRepository.php

---

[back to index](index.md)

