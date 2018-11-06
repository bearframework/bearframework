# BearFramework\App\ClassesRepository

Provides functionality for registering and autoloading classes.

## Methods

##### public [__construct](bearframework.app.classesrepository.__construct.method.md) ( void )

##### public self [add](bearframework.app.classesrepository.add.method.md) ( string $class , string $filename )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers a class for autoloading.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public boolen [exists](bearframework.app.classesrepository.exists.method.md) ( string $class )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information about whether a class is registered for autoloading.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: TRUE if the class is registered for autoloading. FALSE otherwise.

##### public self [load](bearframework.app.classesrepository.load.method.md) ( string $class )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loads a class if registered.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

## Details

File: /src/App/ClassesRepository.php

---

[back to index](index.md)

