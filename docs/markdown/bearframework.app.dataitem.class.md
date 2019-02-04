# BearFramework\App\DataItem

A data item.

```php
BearFramework\App\DataItem {

	/* Properties */
	public string|null $key
	public BearFramework\DataObject $metadata
	public string|null $value

	/* Methods */
	public __construct ( void )
	protected self defineProperty ( string $name [, array $options = [] ] )
	public array toArray ( void )
	public string toJSON ( void )

}
```

## Properties

##### public string|null $key

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The key of the data item.

##### public [BearFramework\DataObject](bearframework.dataobject.class.md) $metadata

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The metadata of the data item.

##### public string|null $value

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The value of the data item.

## Methods

##### public [__construct](bearframework.app.dataitem.__construct.method.md) ( void )

##### protected self [defineProperty](bearframework.app.dataitem.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property.

##### public array [toArray](bearframework.app.dataitem.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

##### public string [toJSON](bearframework.app.dataitem.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

## Details

Location: ~/src/App/DataItem.php

---

[back to index](index.md)

