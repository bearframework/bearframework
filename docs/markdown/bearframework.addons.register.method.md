# BearFramework\Addons::register

Registers an addon.

```php
public static bool register ( string $id , string $dir [, array $options = [] ] )
```

## Parameters

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$id`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The id of the addon.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$dir`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The directory where the addon files are located.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$options`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The addon options. Available values:
- require - An array containing the ids of addons that must be added before this one.

## Returns

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TRUE if successfully registered. FALSE otherwise.

## Details

Class: [BearFramework\Addons](bearframework.addons.class.md)

File: /src/Addons.php

---

[back to index](index.md)

