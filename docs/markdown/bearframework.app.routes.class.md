# BearFramework\App\Routes

Provides functionality for registering callbacks for specific requests and executing them.

```php
BearFramework\App\Routes {

	/* Methods */
	public self add ( string|string[] $pattern , callable|callable[] $callback )
	public mixed getResponse ( BearFramework\App\Request $request )

}
```

## Methods

##### public self [add](bearframework.app.routes.add.method.md) ( string|string[] $pattern , callable|callable[] $callback )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers a request handler.

##### public mixed [getResponse](bearframework.app.routes.getresponse.method.md) ( [BearFramework\App\Request](bearframework.app.request.class.md) $request )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Finds the matching callback and returns its result.

## Details

Location: ~/src/App/Routes.php

---

[back to index](index.md)

