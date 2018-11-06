# BearFramework\App\Context\Assets

Provides utility functions for assets in the current context.

## Methods

##### public [__construct](bearframework.app.context.assets.__construct.method.md) ( string $dir )

##### public self [addDir](bearframework.app.context.assets.adddir.method.md) ( string $pathname )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers a directory that will be publicly accessible relative to the current addon or application location.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public string|null [getContent](bearframework.app.context.assets.getcontent.method.md) ( string $filename [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the content of the file specified in the current context.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The content of the file or null if file does not exists.

##### public string [getUrl](bearframework.app.context.assets.geturl.method.md) ( string $filename [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a public URL for the specified filename in the current context.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The URL for the specified filename and options.

## Details

File: /src/App/Context/Assets.php

---

[back to index](index.md)

