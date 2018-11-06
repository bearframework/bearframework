# BearFramework\App\Context

Provides information about addons and application location and utility functions.

## Properties

##### public readonly [BearFramework\App\Context\Assets](bearframework.app.context.assets.class.md) $assets

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides utility functions for assets in the current context dir.

##### public readonly [BearFramework\App\Context\Classes](bearframework.app.context.classes.class.md) $classes

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provides functionality for autoloading classes in the current context.

##### public readonly string $dir

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The directory where the current addon or application are located.

## Methods

##### public [__construct](bearframework.app.context.__construct.method.md) ( [BearFramework\App](bearframework.app.class.md) $app , string $dir )

##### public array [toArray](bearframework.app.context.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The object data converted as an array.

##### public string [toJSON](bearframework.app.context.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The object data converted as JSON.

##### protected object [defineProperty](bearframework.app.context.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to the object.

## Details

File: /src/App/Context.php

---

[back to index](index.md)

