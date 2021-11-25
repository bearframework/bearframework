# BearFramework\App\IDataDriver

A data driver interface.

```php
BearFramework\App\IDataDriver {

	/* Methods */
	abstract public void append ( string $key , string $content )
	abstract public void delete ( string $key )
	abstract public void deleteMetadata ( string $key , string $name )
	abstract public void duplicate ( string $sourceKey , string $destinationKey )
	abstract public bool exists ( string $key )
	abstract public BearFramework\App\DataItem|null get ( string $key )
	abstract public BearFramework\App\IDataItemStreamWrapper getDataItemStreamWrapper ( string $key , string $mode )
	abstract public BearFramework\DataList|BearFramework\App\DataItem[] getList ( [ BearFramework\DataList\Context|null $context ] )
	abstract public string|null getMetadata ( string $key , string $name )
	abstract public string|null getValue ( string $key )
	abstract public int|null getValueLength ( string $key )
	abstract public string|null getValueRange ( string $key , int $start , int $end )
	abstract public void rename ( string $sourceKey , string $destinationKey )
	abstract public void set ( BearFramework\App\DataItem $item )
	abstract public void setMetadata ( string $key , string $name , string $value )
	abstract public void setValue ( string $key , string $value )

}
```

## Methods

##### abstract public void [append](bearframework.app.idatadriver.append.method.md) ( string $key , string $content )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Appends data to the data item's value specified. If the data item does not exist, it will be created.

##### abstract public void [delete](bearframework.app.idatadriver.delete.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes the data item specified and it's metadata.

##### abstract public void [deleteMetadata](bearframework.app.idatadriver.deletemetadata.method.md) ( string $key , string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes metadata for the data item key specified.

##### abstract public void [duplicate](bearframework.app.idatadriver.duplicate.method.md) ( string $sourceKey , string $destinationKey )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates a copy of the data item specified.

##### abstract public bool [exists](bearframework.app.idatadriver.exists.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns TRUE if the data item exists. FALSE otherwise.

##### abstract public [BearFramework\App\DataItem](bearframework.app.dataitem.class.md)|null [get](bearframework.app.idatadriver.get.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a stored data item or null if not found.

##### abstract public [BearFramework\App\IDataItemStreamWrapper](bearframework.app.idataitemstreamwrapper.class.md) [getDataItemStreamWrapper](bearframework.app.idatadriver.getdataitemstreamwrapper.method.md) ( string $key , string $mode )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a DataItemStreamWrapper for the key specified.

##### abstract public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\DataItem[]](bearframework.app.dataitem.class.md) [getList](bearframework.app.idatadriver.getlist.method.md) ( [ [BearFramework\DataList\Context](bearframework.datalist.context.class.md)|null $context ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all items in the data storage.

##### abstract public string|null [getMetadata](bearframework.app.idatadriver.getmetadata.method.md) ( string $key , string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieves metadata for the data item specified.

##### abstract public string|null [getValue](bearframework.app.idatadriver.getvalue.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value of a stored data item or null if not found.

##### abstract public int|null [getValueLength](bearframework.app.idatadriver.getvaluelength.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value length of a stored data item or null if not found.

##### abstract public string|null [getValueRange](bearframework.app.idatadriver.getvaluerange.method.md) ( string $key , int $start , int $end )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a range of the value of a stored data item or null if not found.

##### abstract public void [rename](bearframework.app.idatadriver.rename.method.md) ( string $sourceKey , string $destinationKey )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Changes the key of the data item specified.

##### abstract public void [set](bearframework.app.idatadriver.set.method.md) ( [BearFramework\App\DataItem](bearframework.app.dataitem.class.md) $item )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores a data item.

##### abstract public void [setMetadata](bearframework.app.idatadriver.setmetadata.method.md) ( string $key , string $name , string $value )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores metadata for the data item specified.

##### abstract public void [setValue](bearframework.app.idatadriver.setvalue.method.md) ( string $key , string $value )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a new value of the item specified or creates a new item with the key and value specified.

## Details

Location: ~/src/App/FileDataDriver.php

---

[back to index](index.md)

