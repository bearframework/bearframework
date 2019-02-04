# BearFramework\App\IDataDriver

A data driver interface.

```php
BearFramework\App\IDataDriver {

	/* Methods */
	public abstract void append ( string $key , string $content )
	public abstract void delete ( string $key )
	public abstract void deleteMetadata ( string $key , string $name )
	public abstract void duplicate ( string $sourceKey , string $destinationKey )
	public abstract bool exists ( string $key )
	public abstract BearFramework\App\DataItem|null get ( string $key )
	public abstract BearFramework\App\IDataItemStreamWrapper getDataItemStreamWrapper ( string $key )
	public abstract BearFramework\DataList|BearFramework\App\DataItem[] getList ( BearFramework\DataListContext $context )
	public abstract string|null getMetadata ( string $key , string $name )
	public abstract string|null getValue ( string $key )
	public abstract void rename ( string $sourceKey , string $destinationKey )
	public abstract void set ( BearFramework\App\DataItem $item )
	public abstract void setMetadata ( string $key , string $name , string $value )
	public abstract void setValue ( string $key , string $value )

}
```

## Methods

##### public abstract void [append](bearframework.app.idatadriver.append.method.md) ( string $key , string $content )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Appends data to the data item's value specified. If the data item does not exist, it will be created.

##### public abstract void [delete](bearframework.app.idatadriver.delete.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes the data item specified and it's metadata.

##### public abstract void [deleteMetadata](bearframework.app.idatadriver.deletemetadata.method.md) ( string $key , string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes metadata for the data item key specified.

##### public abstract void [duplicate](bearframework.app.idatadriver.duplicate.method.md) ( string $sourceKey , string $destinationKey )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates a copy of the data item specified.

##### public abstract bool [exists](bearframework.app.idatadriver.exists.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns TRUE if the data item exists. FALSE otherwise.

##### public abstract [BearFramework\App\DataItem](bearframework.app.dataitem.class.md)|null [get](bearframework.app.idatadriver.get.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a stored data item or null if not found.

##### public abstract [BearFramework\App\IDataItemStreamWrapper](bearframework.app.idataitemstreamwrapper.class.md) [getDataItemStreamWrapper](bearframework.app.idatadriver.getdataitemstreamwrapper.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a DataItemStreamWrapper for the key specified.

##### public abstract [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\DataItem[]](bearframework.app.dataitem.class.md) [getList](bearframework.app.idatadriver.getlist.method.md) ( [BearFramework\DataListContext](bearframework.datalistcontext.class.md) $context )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all items in the data storage.

##### public abstract string|null [getMetadata](bearframework.app.idatadriver.getmetadata.method.md) ( string $key , string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieves metadata for the data item specified.

##### public abstract string|null [getValue](bearframework.app.idatadriver.getvalue.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value of a stored data item or null if not found.

##### public abstract void [rename](bearframework.app.idatadriver.rename.method.md) ( string $sourceKey , string $destinationKey )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Changes the key of the data item specified.

##### public abstract void [set](bearframework.app.idatadriver.set.method.md) ( [BearFramework\App\DataItem](bearframework.app.dataitem.class.md) $item )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores a data item.

##### public abstract void [setMetadata](bearframework.app.idatadriver.setmetadata.method.md) ( string $key , string $name , string $value )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores metadata for the data item specified.

##### public abstract void [setValue](bearframework.app.idatadriver.setvalue.method.md) ( string $key , string $value )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a new value of the item specified or creates a new item with the key and value specified.

## Details

Location: ~/src/App/FileDataDriver.php

---

[back to index](index.md)

