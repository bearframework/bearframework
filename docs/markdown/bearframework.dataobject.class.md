# BearFramework\DataObject

Base class for lists.

```php
BearFramework\DataObject extends IvoPetkov\DataObject implements ArrayAccess {

}
```

## Extends

##### IvoPetkov\DataObject

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A data object that supports registering properties and importing/exporting from array and JSON.

## Implements

##### [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

## Methods

### Inherited from IvoPetkov\DataObject

##### public __construct ( [ array $data = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new data object.

##### public static object fromArray ( array $data )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates an object and fills its properties from the array specified.

##### public static object fromJSON ( string $data )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates an object and fills its properties from the JSON specified.

##### public array toArray ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

##### public string toJSON ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

## Details

Location: ~/src/DataObject.php

---

[back to index](index.md)

