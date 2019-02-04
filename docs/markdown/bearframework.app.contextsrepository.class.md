# BearFramework\App\ContextsRepository

Provides information about your code context (the directory its located).

```php
BearFramework\App\ContextsRepository {

	/* Methods */
	public __construct ( BearFramework\App $app )
	public self add ( string $dir )
	public BearFramework\App\Context get ( [ string|null $filename ] )

}
```

## Methods

##### public [__construct](bearframework.app.contextsrepository.__construct.method.md) ( [BearFramework\App](bearframework.app.class.md) $app )

##### public self [add](bearframework.app.contextsrepository.add.method.md) ( string $dir )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers a new context dir.

##### public [BearFramework\App\Context](bearframework.app.context.class.md) [get](bearframework.app.contextsrepository.get.method.md) ( [ string|null $filename ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a context object for the filename specified.

## Details

Location: ~/src/App/ContextsRepository.php

---

[back to index](index.md)

