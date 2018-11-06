# BearFramework\App\DataRepository

Data storage

## Methods

##### public [__construct](bearframework.app.datarepository.__construct.method.md) ( [BearFramework\App](bearframework.app.class.md) $app [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new data repository.

##### public void [addEventListener](bearframework.app.datarepository.addeventlistener.method.md) ( string $name , callable $listener )

##### public self [append](bearframework.app.datarepository.append.method.md) ( string $key , string $content )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Appends data to the data item's value specified. If the data item does not exist, it will be created.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public self [delete](bearframework.app.datarepository.delete.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes the data item specified and it's metadata.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public self [deleteMetadata](bearframework.app.datarepository.deletemetadata.method.md) ( string $key , string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deletes metadata for the data item key specified.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public void [dispatchEvent](bearframework.app.datarepository.dispatchevent.method.md) ( [BearFramework\App\Event](bearframework.app.event.class.md) $event )

##### public self [duplicate](bearframework.app.datarepository.duplicate.method.md) ( string $sourceKey , string $destinationKey )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates a copy of the data item specified.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public bool [exists](bearframework.app.datarepository.exists.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns TRUE if the data item exists. FALSE otherwise.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: TRUE if the data item exists. FALSE otherwise.

##### public [BearFramework\App\DataItem](bearframework.app.dataitem.class.md)|null [get](bearframework.app.datarepository.get.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a stored data item or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: A data item or null if not found.

##### public string [getFilename](bearframework.app.datarepository.getfilename.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the filename of the data item specified.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The filename of the data item specified.

##### public [BearFramework\DataList](bearframework.datalist.class.md) [getList](bearframework.app.datarepository.getlist.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all items in the data storage.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: A list of all items in the data storage.

##### public string|null [getMetadata](bearframework.app.datarepository.getmetadata.method.md) ( string $key , string $name )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retrieves metadata for the data item specified.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The value of the data item metadata.

##### public [BearFramework\DataList](bearframework.datalist.class.md) [getMetadataList](bearframework.app.datarepository.getmetadatalist.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a list of all data item's metadata.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: A list containing the metadata for the data item specified.

##### public string|null [getValue](bearframework.app.datarepository.getvalue.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the value of a stored data item or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The value of a stored data item or null if not found.

##### public bool [hasEventListeners](bearframework.app.datarepository.haseventlisteners.method.md) ( string $name )

##### public bool [isValidKey](bearframework.app.datarepository.isvalidkey.method.md) ( string $key )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checks if a data item key is valid.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: TRUE if valid. FALSE otherwise.

##### public [BearFramework\App\DataItem](bearframework.app.dataitem.class.md) [make](bearframework.app.datarepository.make.method.md) ( [ string|null $key [, string|null $value ]] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new data item and returns it.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a new data item.

##### public void [removeEventListener](bearframework.app.datarepository.removeeventlistener.method.md) ( string $name , callable $listener )

##### public self [rename](bearframework.app.datarepository.rename.method.md) ( string $sourceKey , string $destinationKey )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Changes the key of the data item specified.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public self [set](bearframework.app.datarepository.set.method.md) ( [BearFramework\App\DataItem](bearframework.app.dataitem.class.md) $item )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores a data item.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public void [setDriver](bearframework.app.datarepository.setdriver.method.md) ( [BearFramework\App\IDataDriver](bearframework.app.idatadriver.class.md) $driver )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a new data driver.

##### public self [setMetadata](bearframework.app.datarepository.setmetadata.method.md) ( string $key , string $name , string $value )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores metadata for the data item specified.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public self [setValue](bearframework.app.datarepository.setvalue.method.md) ( string $key , string $value )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a new value of the item specified or creates a new item with the key and value specified.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a reference to itself.

##### public void [useFileDriver](bearframework.app.datarepository.usefiledriver.method.md) ( string $dir )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enables the file data driver using the directory specified.

## Events

##### getList

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Data\GetListEvent](bearframework.app.data.getlistevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data items list is requested.

##### itemAppend

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Data\ItemAppendEvent](bearframework.app.data.itemappendevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a content is appended to a data value.

##### itemChange

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Data\ItemChangeEvent](bearframework.app.data.itemchangeevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is changed.

##### itemDelete

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Data\ItemDeleteEvent](bearframework.app.data.itemdeleteevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is deleted.

##### itemDeleteMetadata

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Data\ItemDeleteMetadataEvent](bearframework.app.data.itemdeletemetadataevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item metadata is deleted.

##### itemDuplicate

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Data\ItemDuplicateEvent](bearframework.app.data.itemduplicateevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is duplicated.

##### itemExists

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Data\ItemExistsEvent](bearframework.app.data.itemexistsevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is checked for existence.

##### itemGet

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Data\ItemGetEvent](bearframework.app.data.itemgetevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is requested.

##### itemGetMetadata

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Data\ItemGetMetadataEvent](bearframework.app.data.itemgetmetadataevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item metadata is requested.

##### itemGetMetadataList

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Data\ItemGetMetadataListEvent](bearframework.app.data.itemgetmetadatalistevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item metadata list is requested.

##### itemGetValue

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Data\ItemGetValueEvent](bearframework.app.data.itemgetvalueevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the value of a data item is requested.

##### itemRename

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Data\ItemRenameEvent](bearframework.app.data.itemrenameevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is renamed.

##### itemRequest

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Data\ItemRequestEvent](bearframework.app.data.itemrequestevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is requested.

##### itemSet

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Data\ItemSetEvent](bearframework.app.data.itemsetevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item is added or updated.

##### itemSetMetadata

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Data\ItemSetMetadataEvent](bearframework.app.data.itemsetmetadataevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after a data item metadata is added or updated.

##### itemSetValue

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: [BearFramework\App\Data\ItemSetValueEvent](bearframework.app.data.itemsetvalueevent.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An event dispatched after the value of a data item is added or updated.

## Details

File: /src/App/DataRepository.php

---

[back to index](index.md)

