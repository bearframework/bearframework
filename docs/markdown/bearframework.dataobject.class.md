# BearFramework\DataObject

```php
BearFramework\DataObject implements ArrayAccess {

	/* Methods */
	public static object fromArray ( array $data )
	public static object fromJSON ( string $data )
	public array toArray ( [ array $options = [] ] )
	public string toJSON ( [ array $options = [] ] )

}
```

## Implements

##### [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

## Methods

##### public static object [fromArray](bearframework.dataobject.fromarray.method.md) ( array $data )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates an object and fills its properties from the array specified.

##### public static object [fromJSON](bearframework.dataobject.fromjson.method.md) ( string $data )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates an object and fills its properties from the JSON specified.

##### public array [toArray](bearframework.dataobject.toarray.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

##### public string [toJSON](bearframework.dataobject.tojson.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

## Details

Location: ~/src/DataObject.php

---

[back to index](index.md)

