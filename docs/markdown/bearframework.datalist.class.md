# BearFramework\DataList

Base class for lists.

```php
BearFramework\DataList extends IvoPetkov\DataList implements Traversable, Iterator, ArrayAccess {

}
```

## Extends

##### IvoPetkov\DataList

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A list of data objects that can be easily filtered, sorted, etc. The objects can be lazy loaded using a callback in the constructor.

## Implements

##### [Traversable](http://php.net/manual/en/class.traversable.php)

##### [Iterator](http://php.net/manual/en/class.iterator.php)

##### [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

## Methods

### Inherited from IvoPetkov\DataList

##### public __construct ( [ array|iterable|callback $dataSource ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new data objects list.

##### public IvoPetkov\DataList concat ( IvoPetkov\DataList $list )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Appends the items of the list provided to the current list.

##### public IvoPetkov\DataList filter ( callable $callback )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filters the elements of the list using a callback function.

##### public IvoPetkov\DataList filterBy ( string $property , mixed $value [, string $operator = 'equal' ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filters the elements of the list by specific property value.

##### public IvoPetkov\DataObject|null get ( int $index )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object at the index specified or null if not found.

##### public IvoPetkov\DataObject|null getFirst ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the first object or null if not found.

##### public IvoPetkov\DataObject|null getLast ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the last object or null if not found.

##### public IvoPetkov\DataObject|null getRandom ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a random object from the list or null if the list is empty.

##### public IvoPetkov\DataList map ( callable $callback )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Applies the callback to the objects of the list.

##### public IvoPetkov\DataObject|null pop ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pops an object off the end of the list.

##### public IvoPetkov\DataList push ( IvoPetkov\DataObject|array $object )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pushes an object onto the end of the list.

##### public IvoPetkov\DataList reverse ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reverses the order of the objects in the list.

##### public IvoPetkov\DataObject|null shift ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shift an object off the beginning of the list.

##### public IvoPetkov\DataList shuffle ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Randomly reorders the objects in the list.

##### public IvoPetkov\DataList slice ( int $offset [, int $length ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Extract a slice of the list.

##### public IvoPetkov\DataList sliceProperties ( array $properties )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a new list of object that contain only the specified properties of the objects in the current list.

##### public IvoPetkov\DataList sort ( callable $callback )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sorts the elements of the list using a callback function.

##### public IvoPetkov\DataList sortBy ( string $property [, string $order = 'asc' ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sorts the elements of the list by specific property.

##### public array toArray ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the list data converted as an array.

##### public string toJSON ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the list data converted as JSON.

##### public IvoPetkov\DataList unshift ( IvoPetkov\DataObject|array $object )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prepends an object to the beginning of the list.

## Details

Location: ~/src/DataList.php

---

[back to index](index.md)

