# BearFramework\App\Context\Assets

Provides utility functions for assets in the current context.

```php
BearFramework\App\Context\Assets {

	/* Methods */
	public __construct ( BearFramework\App $app , string $dir )
	public self addDir ( string $pathname )
	public string|null getContent ( string $filename [, array $options = [] ] )
	public array getDetails ( string $filename , array $list )
	public string getURL ( string $filename [, array $options = [] ] )

}
```

## Methods

##### public [__construct](bearframework.app.context.assets.__construct.method.md) ( [BearFramework\App](bearframework.app.class.md) $app , string $dir )

##### public self [addDir](bearframework.app.context.assets.adddir.method.md) ( string $pathname )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers a directory that will be publicly accessible relative to the current addon or application location.

##### public string|null [getContent](bearframework.app.context.assets.getcontent.method.md) ( string $filename [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the content of the file specified in the current context.

##### public array [getDetails](bearframework.app.context.assets.getdetails.method.md) ( string $filename , array $list )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of details for the filename specifie in the current context.

##### public string [getURL](bearframework.app.context.assets.geturl.method.md) ( string $filename [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a public URL for the specified filename in the current context.

## Details

Location: ~/src/App/Context/Assets.php

---

[back to index](index.md)

