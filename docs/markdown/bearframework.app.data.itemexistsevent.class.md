# BearFramework\App\Data\ItemExistsEvent

```php
BearFramework\App\Data\ItemExistsEvent extends BearFramework\App\Event {

	/* Properties */
	public bool $exists
	public string $key

	/* Methods */
	public __construct ( string $key , bool $exists )

}
```

## Extends

##### [BearFramework\App\Event](bearframework.app.event.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A base event object.

## Properties

##### public bool $exists

##### public string $key

## Methods

##### public [__construct](bearframework.app.data.itemexistsevent.__construct.method.md) ( string $key , bool $exists )

### Inherited from [BearFramework\App\Event](bearframework.app.event.class.md)

##### protected self [defineProperty](bearframework.app.event.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property.

##### public string [getName](bearframework.app.event.getname.method.md) ( void )

## Details

Location: ~/src/App/Data/ItemExistsEvent.php

---

[back to index](index.md)

