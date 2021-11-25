# BearFramework\DataList

Base class for lists.

```php
BearFramework\DataList implements ArrayAccess, Iterator, Countable, Traversable {

	/* Methods */
	public __construct ( [ array|iterable|callback $dataSource ] )
	public self concat ( array|iterable $list )
	public int count ( void )
	public self filter ( callable $callback )
	public self filterBy ( string $property , mixed $value [, string $operator = 'equal' ] )
	public object|null get ( int $index )
	public object|null getFirst ( void )
	public object|null getLast ( void )
	public object|null getRandom ( void )
	public self map ( callable $callback )
	public object|null pop ( void )
	public self push ( object|array $object )
	public self reverse ( void )
	public object|null shift ( void )
	public self shuffle ( void )
	public mixed slice ( int $offset [, int $length ] )
	public mixed sliceProperties ( array $properties )
	public self sort ( callable $callback )
	public self sortBy ( string $property [, string $order = 'asc' ] )
	public array toArray ( void )
	public string toJSON ( void )
	public self unshift ( object|array $object )

}
```

## Implements

##### [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

##### [Iterator](http://php.net/manual/en/class.iterator.php)

##### [Countable](http://php.net/manual/en/class.countable.php)

##### [Traversable](http://php.net/manual/en/class.traversable.php)

## Methods

##### public [__construct](bearframework.datalist.__construct.method.md) ( [ array|iterable|callback $dataSource ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new data list.

##### public self [concat](bearframework.datalist.concat.method.md) ( array|iterable $list )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Appends the items of the list provided to the current list.

##### public int [count](bearframework.datalist.count.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the number of items in the list.

##### public self [filter](bearframework.datalist.filter.method.md) ( callable $callback )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filters the elements of the list using a callback function.

##### public self [filterBy](bearframework.datalist.filterby.method.md) ( string $property , mixed $value [, string $operator = 'equal' ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filters the elements of the list by specific property value.

##### public object|null [get](bearframework.datalist.get.method.md) ( int $index )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object at the index specified or null if not found.

##### public object|null [getFirst](bearframework.datalist.getfirst.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the first object or null if not found.

##### public object|null [getLast](bearframework.datalist.getlast.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the last object or null if not found.

##### public object|null [getRandom](bearframework.datalist.getrandom.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a random object from the list or null if the list is empty.

##### public self [map](bearframework.datalist.map.method.md) ( callable $callback )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Applies the callback to the objects of the list.

##### public object|null [pop](bearframework.datalist.pop.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pops an object off the end of the list.

##### public self [push](bearframework.datalist.push.method.md) ( object|array $object )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pushes an object onto the end of the list.

##### public self [reverse](bearframework.datalist.reverse.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reverses the order of the objects in the list.

##### public object|null [shift](bearframework.datalist.shift.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shift an object off the beginning of the list.

##### public self [shuffle](bearframework.datalist.shuffle.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Randomly reorders the objects in the list.

##### public mixed [slice](bearframework.datalist.slice.method.md) ( int $offset [, int $length ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Extract a slice of the list.

##### public mixed [sliceProperties](bearframework.datalist.sliceproperties.method.md) ( array $properties )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a new list of object that contain only the specified properties of the objects in the current list.

##### public self [sort](bearframework.datalist.sort.method.md) ( callable $callback )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sorts the elements of the list using a callback function.

##### public self [sortBy](bearframework.datalist.sortby.method.md) ( string $property [, string $order = 'asc' ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sorts the elements of the list by specific property.

##### public array [toArray](bearframework.datalist.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the list data converted as an array.

##### public string [toJSON](bearframework.datalist.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the list data converted as JSON.

##### public self [unshift](bearframework.datalist.unshift.method.md) ( object|array $object )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prepends an object to the beginning of the list.

## Details

Location: ~/src/DataList.php

---

[back to index](index.md)

