# BearFramework\App\Event::defineProperty

Defines a new property.

```php
protected self defineProperty ( string $name [, array $options = [] ] )
```

## Parameters

##### name

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The property name.

##### options

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The property options. Available values:
init (callable)
get (callable)
set (callable)
unset (callable)
readonly (boolean)
type (string)
encodeInJSON (boolean) - Base64 encode the value of the property when it's json encoded (in toJSON() for example). The default value is FALSE.

## Returns

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a reference to the object.

## Details

Class: [BearFramework\App\Event](bearframework.app.event.class.md)

Location: ~/src/App/Assets/BeforeGetDetailsEvent.php

---

[back to index](index.md)

