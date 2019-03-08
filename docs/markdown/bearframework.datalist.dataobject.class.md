# BearFramework\DataList\DataObject

```php
BearFramework\DataList\DataObject implements ArrayAccess {

	/* Methods */
	public static object fromArray ( array $data )
	public static object fromJSON ( string $data )
	public array toArray ( void )
	public string toJSON ( void )

}
```

## Implements

##### [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

## Methods

##### public static object [fromArray](bearframework.datalist.dataobject.fromarray.method.md) ( array $data )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates an object and fills its properties from the array specified.

##### public static object [fromJSON](bearframework.datalist.dataobject.fromjson.method.md) ( string $data )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates an object and fills its properties from the JSON specified.

##### public array [toArray](bearframework.datalist.dataobject.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

##### public string [toJSON](bearframework.datalist.dataobject.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

## Details

Location: ~/src/DataList/DataObject.php

---

[back to index](index.md)

