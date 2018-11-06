# BearFramework\App\Request\FormDataFileItem

extends [BearFramework\App\Request\FormDataItem](bearframework.app.request.formdataitem.class.md)

## Properties

##### public string $filename

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The temporary filename where the uploaded file was stored.

##### public int|null $size

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The size, in bytes, of the uploaded file.

##### public string|null $type

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The mime type of the file, if the browser provided this information.

## Methods

##### public [__construct](bearframework.app.request.formdatafileitem.__construct.method.md) ( void )

### Inherited from [BearFramework\App\Request\FormDataItem](bearframework.app.request.formdataitem.class.md):

##### public array [toArray](bearframework.app.request.formdataitem.toarray.method.md) ( void )

##### public string [toJSON](bearframework.app.request.formdataitem.tojson.method.md) ( void )

##### protected object [defineProperty](bearframework.app.request.formdataitem.defineproperty.method.md) ( string $name [, array $options = [] ] )

## Details

File: /src/App/Request/FormDataFileItem.php

---

[back to index](index.md)

