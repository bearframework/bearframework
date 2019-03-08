# BearFramework\App\Classes

Provides functionality for registering and autoloading classes.

```php
BearFramework\App\Classes {

	/* Methods */
	public __construct ( void )
	public self add ( string $class , string $filename )
	public boolen exists ( string $class )
	public self load ( string $class )

}
```

## Methods

##### public [__construct](bearframework.app.classes.__construct.method.md) ( void )

##### public self [add](bearframework.app.classes.add.method.md) ( string $class , string $filename )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers a class for autoloading.

##### public boolen [exists](bearframework.app.classes.exists.method.md) ( string $class )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information about whether a class is registered for autoloading.

##### public self [load](bearframework.app.classes.load.method.md) ( string $class )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loads a class if registered.

## Details

Location: ~/src/App/Classes.php

---

[back to index](index.md)

