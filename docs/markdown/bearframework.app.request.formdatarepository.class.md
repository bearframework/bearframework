# BearFramework\App\Request\FormDataRepository

Provides information about the response form data items.

## Methods

##### public self [delete](bearframework.app.request.formdatarepository.delete.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a form data item if exists.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public bool [exists](bearframework.app.request.formdatarepository.exists.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether a form data item with the name specified exists.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: TRUE if a form data item with the name specified exists, FALSE otherwise.

##### public [BearFramework\App\Request\FormDataItem](bearframework.app.request.formdataitem.class.md)|null [get](bearframework.app.request.formdatarepository.get.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a form data item or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The form data item requested of null if not found.

##### public [BearFramework\App\Request\FormDataFileItem](bearframework.app.request.formdatafileitem.class.md)|null [getFile](bearframework.app.request.formdatarepository.getfile.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a file data item or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The file data item requested of null if not found.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\Request\FormDataItem[]](bearframework.app.request.formdataitem.class.md) [getList](bearframework.app.request.formdatarepository.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all form data items.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: An array containing all form data items.

##### public string|null [getValue](bearframework.app.request.formdatarepository.getvalue.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a form data item value or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The form data item value requested of null if not found.

##### public [BearFramework\App\Request\FormDataItem](bearframework.app.request.formdataitem.class.md) [make](bearframework.app.request.formdatarepository.make.method.md) ( [ string $name [, string $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new form data item and returns it.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a new form data item.

##### public self [set](bearframework.app.request.formdatarepository.set.method.md) ( [BearFramework\App\Request\FormDataItem](bearframework.app.request.formdataitem.class.md) $dataItem )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a form data item.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

## Details

File: /src/App/Request/FormDataRepository.php

---

[back to index](index.md)

