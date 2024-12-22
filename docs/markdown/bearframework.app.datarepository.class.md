# BearFramework\App\DataRepository

Data storage

```php
BearFramework\App\DataRepository {

	/* Methods */
	public __construct ( [ array $options = [] ] )
	public self addEventListener ( string $name , callable $listener )
	public self append ( string $key , string $content )
	public self delete ( string $key )
	public self deleteMetadata ( string $key , string $name )
	public self dispatchEvent ( string $name [, mixed $details [, array $options = [] ]] )
	public self duplicate ( string $sourceKey , string $destinationKey )
	public bool exists ( string $key )
	public BearFramework\App\DataItem|null get ( string $key )
	public string getFilename ( string $key )
	public int getFreeSpace ( void )
	public BearFramework\DataList|BearFramework\App\DataItem[] getList ( void )
	public string|null getMetadata ( string $key , string $name )
	public string|null getValue ( string $key )
	public string|null getValueLength ( string $key )
	public bool hasEventListeners ( string $name )
	public BearFramework\App\DataItem make ( [ string|null $key [, string|null $value ]] )
	public self removeEventListener ( string $name , callable $listener )
	public self rename ( string $sourceKey , string $destinationKey )
	public self set ( BearFramework\App\DataItem $item )
	public self setDriver ( BearFramework\App\IDataDriver $driver )
	public self setMetadata ( string $key , string $name , string $value )
	public self setValue ( string $key , string $value )
	public self useFileDriver ( string $dir )
	public self useMemoryDriver ( void )
	public self useNullDriver ( void )
	public bool validate ( string $key )

}
```

## Methods

##### public [__construct](bearframework.app.datarepository.__construct.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new data repository.

##### public self [addEventListener](bearframework.app.datarepository.addeventlistener.method.md) ( string $name , callable $listener )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registers a new event listener.

##### public self [append](bearframework.app.datarepository.append.method.md) ( string $key , string $content )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Appends data to the data item's value specified. If the data item does not exist, it will be created.

##### public self [delete](bearframework.app.datarepository.delete.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes the data item specified and it's metadata.

##### public self [deleteMetadata](bearframework.app.datarepository.deletemetadata.method.md) ( string $key , string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes metadata for the data item key specified.

##### public self [dispatchEvent](bearframework.app.datarepository.dispatchevent.method.md) ( string $name [, mixed $details [, array $options = [] ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Calls the registered listeners (in order) for the event name specified.

##### public self [duplicate](bearframework.app.datarepository.duplicate.method.md) ( string $sourceKey , string $destinationKey )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates a copy of the data item specified.

##### public bool [exists](bearframework.app.datarepository.exists.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns TRUE if the data item exists. FALSE otherwise.

##### public [BearFramework\App\DataItem](bearframework.app.dataitem.class.md)|null [get](bearframework.app.datarepository.get.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a stored data item or null if not found.

##### public string [getFilename](bearframework.app.datarepository.getfilename.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the filename of the data item specified.

##### public int [getFreeSpace](bearframework.app.datarepository.getfreespace.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the available free space (in bytes) for data items.

##### public [BearFramework\DataList](bearframework.datalist.class.md)|[BearFramework\App\DataItem[]](bearframework.app.dataitem.class.md) [getList](bearframework.app.datarepository.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all items in the data storage.

##### public string|null [getMetadata](bearframework.app.datarepository.getmetadata.method.md) ( string $key , string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieves metadata for the data item specified.

##### public string|null [getValue](bearframework.app.datarepository.getvalue.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value of a stored data item or null if not found.

##### public string|null [getValueLength](bearframework.app.datarepository.getvaluelength.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value of a stored data item or null if not found.

##### public bool [hasEventListeners](bearframework.app.datarepository.haseventlisteners.method.md) ( string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns TRUE if there are registered event listeners for the name specified, FALSE otherwise.

##### public [BearFramework\App\DataItem](bearframework.app.dataitem.class.md) [make](bearframework.app.datarepository.make.method.md) ( [ string|null $key [, string|null $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new data item and returns it.

##### public self [removeEventListener](bearframework.app.datarepository.removeeventlistener.method.md) ( string $name , callable $listener )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Removes a registered event listener.

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

##### public self [useMemoryDriver](bearframework.app.datarepository.usememorydriver.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enables a memory data driver. All the data will be stored in the request memory and will be deleted when the request ends.

##### public self [useNullDriver](bearframework.app.datarepository.usenulldriver.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enables a null data driver. No data is stored and no errors are thrown.

##### public bool [validate](bearframework.app.datarepository.validate.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checks if a data item key is valid.

## Events

##### [BearFramework\App\Data\BeforeGetListEventDetails](bearframework.app.data.beforegetlisteventdetails.class.md) beforeGetList

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before a data items list is requested.

##### [BearFramework\App\Data\GetListEventDetails](bearframework.app.data.getlisteventdetails.class.md) getList

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data items list is requested.

##### [BearFramework\App\Data\ItemAppendEventDetails](bearframework.app.data.itemappendeventdetails.class.md) itemAppend

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a content is appended to a data value.

##### [BearFramework\App\Data\ItemBeforeAppendEventDetails](bearframework.app.data.itembeforeappendeventdetails.class.md) itemBeforeAppend

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before a content is appended to a data value.

##### [BearFramework\App\Data\ItemBeforeDeleteEventDetails](bearframework.app.data.itembeforedeleteeventdetails.class.md) itemBeforeDelete

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before a data item is deleted.

##### [BearFramework\App\Data\ItemBeforeDeleteMetadataEventDetails](bearframework.app.data.itembeforedeletemetadataeventdetails.class.md) itemBeforeDeleteMetadata

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before a data item metadata is deleted.

##### [BearFramework\App\Data\ItemBeforeDuplicateEventDetails](bearframework.app.data.itembeforeduplicateeventdetails.class.md) itemBeforeDuplicate

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before a data item is duplicated.

##### [BearFramework\App\Data\ItemBeforeExistsEventDetails](bearframework.app.data.itembeforeexistseventdetails.class.md) itemBeforeExists

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before a data item is checked for existence.

##### [BearFramework\App\Data\ItemBeforeGetEventDetails](bearframework.app.data.itembeforegeteventdetails.class.md) itemBeforeGet

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before a data item is requested.

##### [BearFramework\App\Data\ItemBeforeGetMetadataEventDetails](bearframework.app.data.itembeforegetmetadataeventdetails.class.md) itemBeforeGetMetadata

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before a data item metadata is requested.

##### [BearFramework\App\Data\ItemBeforeGetStreamWrapperEventDetails](bearframework.app.data.itembeforegetstreamwrappereventdetails.class.md) itemBeforeGetStreamWrapper

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched when a data items stream wrapper is requested.

##### [BearFramework\App\Data\ItemBeforeGetValueEventDetails](bearframework.app.data.itembeforegetvalueeventdetails.class.md) itemBeforeGetValue

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the value of a data item is requested.

##### [BearFramework\App\Data\ItemBeforeGetValueLengthEventDetails](bearframework.app.data.itembeforegetvaluelengtheventdetails.class.md) itemBeforeGetValueLength

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the value length of a data item is requested.

##### [BearFramework\App\Data\ItemBeforeRenameEventDetails](bearframework.app.data.itembeforerenameeventdetails.class.md) itemBeforeRename

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before a data item is renamed.

##### [BearFramework\App\Data\ItemBeforeSetEventDetails](bearframework.app.data.itembeforeseteventdetails.class.md) itemBeforeSet

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before a data item is added or updated.

##### [BearFramework\App\Data\ItemBeforeSetMetadataEventDetails](bearframework.app.data.itembeforesetmetadataeventdetails.class.md) itemBeforeSetMetadata

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before a data item metadata is added or updated.

##### [BearFramework\App\Data\ItemBeforeSetValueEventDetails](bearframework.app.data.itembeforesetvalueeventdetails.class.md) itemBeforeSetValue

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched before the value of a data item is added or updated.

##### [BearFramework\App\Data\ItemChangeEventDetails](bearframework.app.data.itemchangeeventdetails.class.md) itemChange

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is changed.

##### [BearFramework\App\Data\ItemDeleteEventDetails](bearframework.app.data.itemdeleteeventdetails.class.md) itemDelete

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is deleted.

##### [BearFramework\App\Data\ItemDeleteMetadataEventDetails](bearframework.app.data.itemdeletemetadataeventdetails.class.md) itemDeleteMetadata

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item metadata is deleted.

##### [BearFramework\App\Data\ItemDuplicateEventDetails](bearframework.app.data.itemduplicateeventdetails.class.md) itemDuplicate

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is duplicated.

##### [BearFramework\App\Data\ItemExistsEventDetails](bearframework.app.data.itemexistseventdetails.class.md) itemExists

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is checked for existence.

##### [BearFramework\App\Data\ItemGetEventDetails](bearframework.app.data.itemgeteventdetails.class.md) itemGet

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is requested.

##### [BearFramework\App\Data\ItemGetMetadataEventDetails](bearframework.app.data.itemgetmetadataeventdetails.class.md) itemGetMetadata

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item metadata is requested.

##### [BearFramework\App\Data\ItemGetValueEventDetails](bearframework.app.data.itemgetvalueeventdetails.class.md) itemGetValue

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the value of a data item is requested.

##### [BearFramework\App\Data\ItemGetValueLengthEventDetails](bearframework.app.data.itemgetvaluelengtheventdetails.class.md) itemGetValueLength

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the value length of a data item is requested.

##### [BearFramework\App\Data\ItemRenameEventDetails](bearframework.app.data.itemrenameeventdetails.class.md) itemRename

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is renamed.

##### [BearFramework\App\Data\ItemRequestEventDetails](bearframework.app.data.itemrequesteventdetails.class.md) itemRequest

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is requested.

##### [BearFramework\App\Data\ItemSetEventDetails](bearframework.app.data.itemseteventdetails.class.md) itemSet

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is added or updated.

##### [BearFramework\App\Data\ItemSetMetadataEventDetails](bearframework.app.data.itemsetmetadataeventdetails.class.md) itemSetMetadata

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item metadata is added or updated.

##### [BearFramework\App\Data\ItemSetValueEventDetails](bearframework.app.data.itemsetvalueeventdetails.class.md) itemSetValue

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the value of a data item is added or updated.

## Details

Location: ~/src/App/DataRepository.php

---

[back to index](index.md)

