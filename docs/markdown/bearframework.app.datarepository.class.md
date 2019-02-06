# BearFramework\App\DataRepository

Data storage

```php
BearFramework\App\DataRepository {

	/* Methods */
	public __construct ( BearFramework\App $app [, array $options = [] ] )
	public self addEventListener ( string $name , callable $listener )
	public self append ( string $key , string $content )
	public self delete ( string $key )
	public self deleteMetadata ( string $key , string $name )
	public self dispatchEvent ( string $name [, mixed $details ] )
	public self duplicate ( string $sourceKey , string $destinationKey )
	public bool exists ( string $key )
	public BearFramework\App\DataItem|null get ( string $key )
	public string getFilename ( string $key )
	public BearFramework\DataList|BearFramework\App\DataItem[] getList ( void )
	public string|null getMetadata ( string $key , string $name )
	public string|null getValue ( string $key )
	public bool hasEventListeners ( string $name )
	public BearFramework\App\DataItem make ( [ string|null $key [, string|null $value ]] )
	public self removeEventListener ( string $name , callable $listener )
	public self rename ( string $sourceKey , string $destinationKey )
	public self set ( BearFramework\App\DataItem $item )
	public self setDriver ( BearFramework\App\IDataDriver $driver )
	public self setMetadata ( string $key , string $name , string $value )
	public self setValue ( string $key , string $value )
	public self useFileDriver ( string $dir )
	public self useNullDriver ( void )
	public bool validate ( string $key )

}
```

## Methods

##### public [__construct](bearframework.app.datarepository.__construct.method.md) ( [BearFramework\App](bearframework.app.class.md) $app [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new data repository.

##### public self [addEventListener](bearframework.app.datarepository.addeventlistener.method.md) ( string $name , callable $listener )

##### public self [append](bearframework.app.datarepository.append.method.md) ( string $key , string $content )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Appends data to the data item's value specified. If the data item does not exist, it will be created.

##### public self [delete](bearframework.app.datarepository.delete.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes the data item specified and it's metadata.

##### public self [deleteMetadata](bearframework.app.datarepository.deletemetadata.method.md) ( string $key , string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes metadata for the data item key specified.

##### public self [dispatchEvent](bearframework.app.datarepository.dispatchevent.method.md) ( string $name [, mixed $details ] )

##### public self [duplicate](bearframework.app.datarepository.duplicate.method.md) ( string $sourceKey , string $destinationKey )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates a copy of the data item specified.

##### public bool [exists](bearframework.app.datarepository.exists.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns TRUE if the data item exists. FALSE otherwise.

##### public [BearFramework\App\DataItem](bearframework.app.dataitem.class.md)|null [get](bearframework.app.datarepository.get.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a stored data item or null if not found.

##### public string [getFilename](bearframework.app.datarepository.getfilename.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the filename of the data item specified.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\DataItem[]](bearframework.app.dataitem.class.md) [getList](bearframework.app.datarepository.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all items in the data storage.

##### public string|null [getMetadata](bearframework.app.datarepository.getmetadata.method.md) ( string $key , string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieves metadata for the data item specified.

##### public string|null [getValue](bearframework.app.datarepository.getvalue.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value of a stored data item or null if not found.

##### public bool [hasEventListeners](bearframework.app.datarepository.haseventlisteners.method.md) ( string $name )

##### public [BearFramework\App\DataItem](bearframework.app.dataitem.class.md) [make](bearframework.app.datarepository.make.method.md) ( [ string|null $key [, string|null $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new data item and returns it.

##### public self [removeEventListener](bearframework.app.datarepository.removeeventlistener.method.md) ( string $name , callable $listener )

##### public self [rename](bearframework.app.datarepository.rename.method.md) ( string $sourceKey , string $destinationKey )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Changes the key of the data item specified.

##### public self [set](bearframework.app.datarepository.set.method.md) ( [BearFramework\App\DataItem](bearframework.app.dataitem.class.md) $item )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores a data item.

##### public self [setDriver](bearframework.app.datarepository.setdriver.method.md) ( [BearFramework\App\IDataDriver](bearframework.app.idatadriver.class.md) $driver )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a new data driver.

##### public self [setMetadata](bearframework.app.datarepository.setmetadata.method.md) ( string $key , string $name , string $value )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores metadata for the data item specified.

##### public self [setValue](bearframework.app.datarepository.setvalue.method.md) ( string $key , string $value )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a new value of the item specified or creates a new item with the key and value specified.

##### public self [useFileDriver](bearframework.app.datarepository.usefiledriver.method.md) ( string $dir )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enables the file data driver using the directory specified.

##### public self [useNullDriver](bearframework.app.datarepository.usenulldriver.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enables a null data driver. No data is stored and no errors are thrown.

##### public bool [validate](bearframework.app.datarepository.validate.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checks if a data item key is valid.

## Events

##### BearFramework\App\Data\GetListEvent getList

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data items list is requested.

##### BearFramework\App\Data\ItemAppendEvent itemAppend

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a content is appended to a data value.

##### BearFramework\App\Data\ItemChangeEvent itemChange

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is changed.

##### BearFramework\App\Data\ItemDeleteEvent itemDelete

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is deleted.

##### BearFramework\App\Data\ItemDeleteMetadataEvent itemDeleteMetadata

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item metadata is deleted.

##### BearFramework\App\Data\ItemDuplicateEvent itemDuplicate

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is duplicated.

##### BearFramework\App\Data\ItemExistsEvent itemExists

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is checked for existence.

##### BearFramework\App\Data\ItemGetEvent itemGet

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is requested.

##### BearFramework\App\Data\ItemGetMetadataEvent itemGetMetadata

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item metadata is requested.

##### BearFramework\App\Data\ItemGetValueEvent itemGetValue

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the value of a data item is requested.

##### BearFramework\App\Data\ItemRenameEvent itemRename

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is renamed.

##### BearFramework\App\Data\ItemRequestEvent itemRequest

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is requested.

##### BearFramework\App\Data\ItemSetEvent itemSet

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is added or updated.

##### BearFramework\App\Data\ItemSetMetadataEvent itemSetMetadata

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item metadata is added or updated.

##### BearFramework\App\Data\ItemSetValueEvent itemSetValue

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the value of a data item is added or updated.

## Details

Location: ~/src/App/DataRepository.php

---

[back to index](index.md)

