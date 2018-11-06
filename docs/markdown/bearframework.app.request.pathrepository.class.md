# BearFramework\App\Request\PathRepository

Provides information about the request path.

## Methods

##### public [__construct](bearframework.app.request.pathrepository.__construct.method.md) ( [ string $path = '' ] )

##### public string [get](bearframework.app.request.pathrepository.get.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the full path.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns the full path.

##### public string|null [getSegment](bearframework.app.request.pathrepository.getsegment.method.md) ( int $index [, bool $decode = true ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value of the path segment for the index specified or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The value of the path segment for the index specified or null if not found.

##### public self [set](bearframework.app.request.pathrepository.set.method.md) ( string $path [, bool $encode = true ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a new path.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

## Details

File: /src/App/Request/PathRepository.php

---

[back to index](index.md)

