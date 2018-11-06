# BearFramework\App\Response\HeadersRepository

A repository for the response headers.

## Methods

##### public self [delete](bearframework.app.response.headersrepository.delete.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes a header if exists.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public bool [exists](bearframework.app.response.headersrepository.exists.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns information whether a header with the name specified exists.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: TRUE if a header with the name specified exists, FALSE otherwise.

##### public [BearFramework\App\Response\Header](bearframework.app.response.header.class.md)|null [get](bearframework.app.response.headersrepository.get.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a header or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The header requested of null if not found.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\Response\Header[]](bearframework.app.response.header.class.md) [getList](bearframework.app.response.headersrepository.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all headers.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: An array containing all headers.

##### public string|null [getValue](bearframework.app.response.headersrepository.getvalue.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value of the header or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The value of the header requested of null if not found.

##### public [BearFramework\App\Response\Header](bearframework.app.response.header.class.md) [make](bearframework.app.response.headersrepository.make.method.md) ( [ string $name [, string $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new header and returns it.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a new header.

##### public self [set](bearframework.app.response.headersrepository.set.method.md) ( [BearFramework\App\Response\Header](bearframework.app.response.header.class.md) $header )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a header.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

## Details

File: /src/App/Response/HeadersRepository.php

---

[back to index](index.md)

