# BearFramework\App\FileLogger

A logger that saves the logs in the directory specified.

```php
BearFramework\App\FileLogger implements BearFramework\App\ILogger {

	/* Methods */
	public __construct ( string $dir )
	public void log ( string $name , string $message [, array $data = [] ] )

}
```

## Implements

##### [BearFramework\App\ILogger](bearframework.app.ilogger.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A logger interface.

## Methods

##### public [__construct](bearframework.app.filelogger.__construct.method.md) ( string $dir )

##### public void [log](bearframework.app.filelogger.log.method.md) ( string $name , string $message [, array $data = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Logs the data specified.

## Details

Location: ~/src/App/FileLogger.php

---

[back to index](index.md)

