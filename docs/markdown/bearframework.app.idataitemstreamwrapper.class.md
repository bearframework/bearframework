# BearFramework\App\IDataItemStreamWrapper

```php
BearFramework\App\IDataItemStreamWrapper {

	/* Methods */
	abstract public void close ( void )
	abstract public bool eof ( void )
	abstract public bool flush ( void )
	abstract public bool open ( string $mode )
	abstract public string read ( int $count )
	abstract public bool seek ( int $offset , int $whence )
	abstract public int size ( void )
	abstract public int tell ( void )
	abstract public bool truncate ( int $newSize )
	abstract public int write ( string $data )

}
```

## Methods

##### abstract public void [close](bearframework.app.idataitemstreamwrapper.close.method.md) ( void )

##### abstract public bool [eof](bearframework.app.idataitemstreamwrapper.eof.method.md) ( void )

##### abstract public bool [flush](bearframework.app.idataitemstreamwrapper.flush.method.md) ( void )

##### abstract public bool [open](bearframework.app.idataitemstreamwrapper.open.method.md) ( string $mode )

##### abstract public string [read](bearframework.app.idataitemstreamwrapper.read.method.md) ( int $count )

##### abstract public bool [seek](bearframework.app.idataitemstreamwrapper.seek.method.md) ( int $offset , int $whence )

##### abstract public int [size](bearframework.app.idataitemstreamwrapper.size.method.md) ( void )

##### abstract public int [tell](bearframework.app.idataitemstreamwrapper.tell.method.md) ( void )

##### abstract public bool [truncate](bearframework.app.idataitemstreamwrapper.truncate.method.md) ( int $newSize )

##### abstract public int [write](bearframework.app.idataitemstreamwrapper.write.method.md) ( string $data )

## Details

Location: ~/src/App/FileDataItemStreamWrapper.php

---

[back to index](index.md)

