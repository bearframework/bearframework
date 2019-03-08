# BearFramework\App\Contexts

Provides information about your code context (the directory its located).

```php
BearFramework\App\Contexts {

	/* Methods */
	public __construct ( BearFramework\App $app )
	public self add ( string $dir )
	public BearFramework\App\Context get ( [ string|null $filename ] )

}
```

## Methods

##### public [__construct](bearframework.app.contexts.__construct.method.md) ( [BearFramework\App](bearframework.app.class.md) $app )

##### public self [add](bearframework.app.contexts.add.method.md) ( string $dir )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers a new context dir.

##### public [BearFramework\App\Context](bearframework.app.context.class.md) [get](bearframework.app.contexts.get.method.md) ( [ string|null $filename ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a context object for the filename specified.

## Details

Location: ~/src/App/Contexts.php

---

[back to index](index.md)

