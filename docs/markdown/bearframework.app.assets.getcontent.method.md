# BearFramework\App\Assets::getContent

Returns the content of the file specified.

```php
public string|null getContent ( string $filename [, array $options = [] ] )
```

## Parameters

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$filename`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The filename.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$options`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;List of options. You can resize the file by providing "width", "height" or both. You can specify encoding too (base64, data-uri, data-uri-base64).

## Returns

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The content of the file or null if file does not exists.

## Details

Class: [BearFramework\App\Assets](bearframework.app.assets.class.md)

File: /src/App/Assets.php

---

[back to index](index.md)

