# BearFramework\App\Assets\GetDetailsEvent

```php
BearFramework\App\Assets\GetDetailsEvent extends BearFramework\App\Event {

	/* Properties */
	public string $filename
	public array $list
	public array|null $returnValue

	/* Methods */
	public __construct ( string $filename , array $list , array $returnValue )

}
```

## Extends

##### [BearFramework\App\Event](bearframework.app.event.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A base event object.

## Properties

##### public string $filename

##### public array $list

##### public array|null $returnValue

## Methods

##### public [__construct](bearframework.app.assets.getdetailsevent.__construct.method.md) ( string $filename , array $list , array $returnValue )

### Inherited from [BearFramework\App\Event](bearframework.app.event.class.md)

##### protected self [defineProperty](bearframework.app.event.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property.

##### public string [getName](bearframework.app.event.getname.method.md) ( void )

## Details

Location: ~/src/App/Assets/GetDetailsEvent.php

---

[back to index](index.md)

