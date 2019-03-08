# BearFramework\App\NullDataDriver

A null data driver. No data is stored and no errors are thrown.

```php
BearFramework\App\NullDataDriver implements BearFramework\App\IDataDriver {

	/* Methods */
	public void append ( string $key , string $content )
	public void delete ( string $key )
	public void deleteMetadata ( string $key , string $name )
	public void duplicate ( string $sourceKey , string $destinationKey )
	public bool exists ( string $key )
	public BearFramework\App\DataItem|null get ( string $key )
	public BearFramework\App\IDataItemStreamWrapper getDataItemStreamWrapper ( string $key )
	public BearFramework\DataList|BearFramework\App\DataItem[] getList ( [ BearFramework\DataList\Context|null $context ] )
	public string|null getMetadata ( string $key , string $name )
	public string|null getValue ( string $key )
	public void rename ( string $sourceKey , string $destinationKey )
	public void set ( BearFramework\App\DataItem $item )
	public void setMetadata ( string $key , string $name , string $value )
	public void setValue ( string $key , string $value )

}
```

## Implements

##### [BearFramework\App\IDataDriver](bearframework.app.idatadriver.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A data driver interface.

## Methods

##### public void [append](bearframework.app.nulldatadriver.append.method.md) ( string $key , string $content )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Appends data to the data item's value specified. If the data item does not exist, it will be created.

##### public void [delete](bearframework.app.nulldatadriver.delete.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes the data item specified and it's metadata.

##### public void [deleteMetadata](bearframework.app.nulldatadriver.deletemetadata.method.md) ( string $key , string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes metadata for the data item key specified.

##### public void [duplicate](bearframework.app.nulldatadriver.duplicate.method.md) ( string $sourceKey , string $destinationKey )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates a copy of the data item specified.

##### public bool [exists](bearframework.app.nulldatadriver.exists.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns TRUE if the data item exists. FALSE otherwise.

##### public [BearFramework\App\DataItem](bearframework.app.dataitem.class.md)|null [get](bearframework.app.nulldatadriver.get.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a stored data item or null if not found.

##### public [BearFramework\App\IDataItemStreamWrapper](bearframework.app.idataitemstreamwrapper.class.md) [getDataItemStreamWrapper](bearframework.app.nulldatadriver.getdataitemstreamwrapper.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a DataItemStreamWrapper for the key specified.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\DataItem[]](bearframework.app.dataitem.class.md) [getList](bearframework.app.nulldatadriver.getlist.method.md) ( [ [BearFramework\DataList\Context](bearframework.datalist.context.class.md)|null $context ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all items in the data storage.

##### public string|null [getMetadata](bearframework.app.nulldatadriver.getmetadata.method.md) ( string $key , string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieves metadata for the data item specified.

##### public string|null [getValue](bearframework.app.nulldatadriver.getvalue.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value of a stored data item or null if not found.

##### public void [rename](bearframework.app.nulldatadriver.rename.method.md) ( string $sourceKey , string $destinationKey )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Changes the key of the data item specified.

##### public void [set](bearframework.app.nulldatadriver.set.method.md) ( [BearFramework\App\DataItem](bearframework.app.dataitem.class.md) $item )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores a data item.

##### public void [setMetadata](bearframework.app.nulldatadriver.setmetadata.method.md) ( string $key , string $name , string $value )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores metadata for the data item specified.

##### public void [setValue](bearframework.app.nulldatadriver.setvalue.method.md) ( string $key , string $value )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a new value of the item specified or creates a new item with the key and value specified.

## Details

Location: ~/src/App/NullDataDriver.php

---

[back to index](index.md)

