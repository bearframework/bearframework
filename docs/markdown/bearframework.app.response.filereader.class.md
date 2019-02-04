# BearFramework\App\Response\FileReader

Response type that reads file and outputs it.

```php
BearFramework\App\Response\FileReader extends BearFramework\App\Response {

	/* Properties */
	public string $filename

	/* Methods */
	public __construct ( string $filename )
	public array toArray ( void )
	public string toJSON ( void )

}
```

## Extends

##### [BearFramework\App\Response](bearframework.app.response.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Response object.

## Properties

##### public string $filename

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The filename to output.

## Methods

##### public [__construct](bearframework.app.response.filereader.__construct.method.md) ( string $filename )

##### public array [toArray](bearframework.app.response.filereader.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

##### public string [toJSON](bearframework.app.response.filereader.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

## Details

Location: ~/src/App/Response/FileReader.php

---

[back to index](index.md)

