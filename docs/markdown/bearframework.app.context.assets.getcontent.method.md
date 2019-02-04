# BearFramework\App\Context\Assets::getContent

Returns the content of the file specified in the current context.

```php
public string|null getContent ( string $filename [, array $options = [] ] )
```

## Parameters

##### filename

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The filename.

##### options

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;List of options. You can resize the file by providing "width", "height" or both. You can specify encoding too (base64 or data-uri).

## Returns

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The content of the file or null if file does not exists.

## Details

Class: [BearFramework\App\Context\Assets](bearframework.app.context.assets.class.md)

Location: ~/src/App/Context/Assets.php

---

[back to index](index.md)

