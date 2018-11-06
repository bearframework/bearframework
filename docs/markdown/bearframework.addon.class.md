# BearFramework\Addon

## Properties

##### public readonly string $dir

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The directory where the addon files are located.

##### public readonly string $id

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The id of the addon.

##### public readonly array $options

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The addon options. Available values:
- require - An array containing the ids of addons that must be added before this one.

## Methods

##### public [__construct](bearframework.addon.__construct.method.md) ( string $id , string $dir , array $options )

##### public array [toArray](bearframework.addon.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The object data converted as an array.

##### public string [toJSON](bearframework.addon.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The object data converted as JSON.

##### protected object [defineProperty](bearframework.addon.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to the object.

## Details

File: /src/Addon.php

---

[back to index](index.md)

