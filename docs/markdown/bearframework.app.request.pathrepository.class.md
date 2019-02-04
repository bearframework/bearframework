# BearFramework\App\Request\PathRepository

Provides information about the request path.

```php
BearFramework\App\Request\PathRepository {

	/* Methods */
	public __construct ( [ string $path = '' ] )
	public string get ( void )
	public string|null getSegment ( int $index )
	public bool match ( string|string[] $pattern )
	public self set ( string $path )

}
```

## Methods

##### public [__construct](bearframework.app.request.pathrepository.__construct.method.md) ( [ string $path = '' ] )

##### public string [get](bearframework.app.request.pathrepository.get.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the full path.

##### public string|null [getSegment](bearframework.app.request.pathrepository.getsegment.method.md) ( int $index )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value of the path segment for the index specified or null if not found.

##### public bool [match](bearframework.app.request.pathrepository.match.method.md) ( string|string[] $pattern )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checks if the current path matches the pattern/patterns specified.

##### public self [set](bearframework.app.request.pathrepository.set.method.md) ( string $path )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a new path.

## Details

Location: ~/src/App/Request/PathRepository.php

---

[back to index](index.md)

