# BearFramework\App\RoutesRepository

Provides functionality for registering callbacks for specific requests and executing them.

## Methods

##### public self [add](bearframework.app.routesrepository.add.method.md) ( string|string[] $pattern , callable|callable[] $callback [, array $options = ["GET"] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers a request handler.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns Returns a reference to itself.

##### public mixed [getResponse](bearframework.app.routesrepository.getresponse.method.md) ( [BearFramework\App\Request](bearframework.app.request.class.md) $request )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Finds the matching callback and returns its result.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The result of the matching callback. NULL if none.

## Details

File: /src/App/RoutesRepository.php

---

[back to index](index.md)

