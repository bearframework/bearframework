# BearFramework\App\Logs

Logs repository

```php
BearFramework\App\Logs {

	/* Methods */
	public self log ( string $name , string $message [, array $data = [] ] )
	public self setLogger ( BearFramework\App\ILogger $logger )
	public self useFileLogger ( string $dir )
	public self useNullLogger ( void )

}
```

## Methods

##### public self [log](bearframework.app.logs.log.method.md) ( string $name , string $message [, array $data = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Logs the data specified.

##### public self [setLogger](bearframework.app.logs.setlogger.method.md) ( [BearFramework\App\ILogger](bearframework.app.ilogger.class.md) $logger )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a new logger.

##### public self [useFileLogger](bearframework.app.logs.usefilelogger.method.md) ( string $dir )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enables a file logger for directory specified.

##### public self [useNullLogger](bearframework.app.logs.usenulllogger.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enables a null logger. The null logger does not log any data and does not throw any errors.

## Details

Location: ~/src/App/Logs.php

---

[back to index](index.md)

