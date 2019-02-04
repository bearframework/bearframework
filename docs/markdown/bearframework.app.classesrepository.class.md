# BearFramework\App\ClassesRepository

Provides functionality for registering and autoloading classes.

```php
BearFramework\App\ClassesRepository {

	/* Methods */
	public __construct ( void )
	public self add ( string $class , string $filename )
	public boolen exists ( string $class )
	public self load ( string $class )

}
```

## Methods

##### public [__construct](bearframework.app.classesrepository.__construct.method.md) ( void )

##### public self [add](bearframework.app.classesrepository.add.method.md) ( string $class , string $filename )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers a class for autoloading.

##### public boolen [exists](bearframework.app.classesrepository.exists.method.md) ( string $class )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information about whether a class is registered for autoloading.

##### public self [load](bearframework.app.classesrepository.load.method.md) ( string $class )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loads a class if registered.

## Details

Location: ~/src/App/ClassesRepository.php

---

[back to index](index.md)

