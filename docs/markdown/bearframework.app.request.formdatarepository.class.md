# BearFramework\App\Request\FormDataRepository

Provides information about the response form data items.

```php
BearFramework\App\Request\FormDataRepository {

	/* Methods */
	public self delete ( string $name )
	public bool exists ( string $name )
	public BearFramework\App\Request\FormDataItem|null get ( string $name )
	public BearFramework\App\Request\FormDataFileItem|null getFile ( string $name )
	public BearFramework\DataList|BearFramework\App\Request\FormDataItem[] getList ( void )
	public string|null getValue ( string $name )
	public BearFramework\App\Request\FormDataItem make ( [ string $name [, string $value ]] )
	public self set ( BearFramework\App\Request\FormDataItem $dataItem )

}
```

## Methods

##### public self [delete](bearframework.app.request.formdatarepository.delete.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a form data item if exists.

##### public bool [exists](bearframework.app.request.formdatarepository.exists.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether a form data item with the name specified exists.

##### public [BearFramework\App\Request\FormDataItem](bearframework.app.request.formdataitem.class.md)|null [get](bearframework.app.request.formdatarepository.get.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a form data item or null if not found.

##### public [BearFramework\App\Request\FormDataFileItem](bearframework.app.request.formdatafileitem.class.md)|null [getFile](bearframework.app.request.formdatarepository.getfile.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a file data item or null if not found.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\Request\FormDataItem[]](bearframework.app.request.formdataitem.class.md) [getList](bearframework.app.request.formdatarepository.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all form data items.

##### public string|null [getValue](bearframework.app.request.formdatarepository.getvalue.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a form data item value or null if not found.

##### public [BearFramework\App\Request\FormDataItem](bearframework.app.request.formdataitem.class.md) [make](bearframework.app.request.formdatarepository.make.method.md) ( [ string $name [, string $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new form data item and returns it.

##### public self [set](bearframework.app.request.formdatarepository.set.method.md) ( [BearFramework\App\Request\FormDataItem](bearframework.app.request.formdataitem.class.md) $dataItem )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a form data item.

## Details

Location: ~/src/App/Request/FormDataRepository.php

---

[back to index](index.md)

