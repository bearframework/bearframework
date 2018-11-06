# BearFramework\App\Config

The application configuration.

## Methods

##### public [__construct](bearframework.app.config.__construct.method.md) ( [ array $options = [] ] )

##### public void [load](bearframework.app.config.load.method.md) ( string $filename )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loads a configuration file. The file must return PHP array containing configuration options in the format ['option1'=>'value1', 'option2'=>'value2'].

##### public array [toArray](bearframework.app.config.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The object data converted as an array.

##### public string [toJSON](bearframework.app.config.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The object data converted as JSON.

##### protected object [defineProperty](bearframework.app.config.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to the object.

## Details

File: /src/App/Config.php

---

[back to index](index.md)

