# BearFramework\App\StringDataItemStreamWrapper

```php
BearFramework\App\StringDataItemStreamWrapper implements BearFramework\App\IDataItemStreamWrapper {

	/* Methods */
	public __construct ( callable $reader , callable $writer )
	public void close ( void )
	public bool eof ( void )
	public bool flush ( void )
	public bool open ( string $mode )
	public string read ( int $count )
	public bool seek ( int $offset , int $whence )
	public int size ( void )
	public int tell ( void )
	public bool truncate ( int $newSize )
	public int write ( string $data )

}
```

## Implements

##### [BearFramework\App\IDataItemStreamWrapper](bearframework.app.idataitemstreamwrapper.class.md)

## Methods

##### public [__construct](bearframework.app.stringdataitemstreamwrapper.__construct.method.md) ( callable $reader , callable $writer )

##### public void [close](bearframework.app.stringdataitemstreamwrapper.close.method.md) ( void )

##### public bool [eof](bearframework.app.stringdataitemstreamwrapper.eof.method.md) ( void )

##### public bool [flush](bearframework.app.stringdataitemstreamwrapper.flush.method.md) ( void )

##### public bool [open](bearframework.app.stringdataitemstreamwrapper.open.method.md) ( string $mode )

##### public string [read](bearframework.app.stringdataitemstreamwrapper.read.method.md) ( int $count )

##### public bool [seek](bearframework.app.stringdataitemstreamwrapper.seek.method.md) ( int $offset , int $whence )

##### public int [size](bearframework.app.stringdataitemstreamwrapper.size.method.md) ( void )

##### public int [tell](bearframework.app.stringdataitemstreamwrapper.tell.method.md) ( void )

##### public bool [truncate](bearframework.app.stringdataitemstreamwrapper.truncate.method.md) ( int $newSize )

##### public int [write](bearframework.app.stringdataitemstreamwrapper.write.method.md) ( string $data )

## Details

Location: ~/src/App/StringDataItemStreamWrapper.php

---

[back to index](index.md)

