# BearFramework\DataList

extends IvoPetkov\DataList

implements [Traversable](http://php.net/manual/en/class.traversable.php), [Iterator](http://php.net/manual/en/class.iterator.php), [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

Base class for lists.

## Methods

### Inherited from IvoPetkov\DataList:

##### public __construct ( [ array|iterable|callback $dataSource ] )

##### public IvoPetkov\DataList concat ( IvoPetkov\DataList $list )

##### public IvoPetkov\DataList filter ( callable $callback )

##### public IvoPetkov\DataList filterBy ( string $property , mixed $value [, string $operator = 'equal' ] )

##### public IvoPetkov\DataObject|null get ( int $index )

##### public IvoPetkov\DataObject|null getFirst ( void )

##### public IvoPetkov\DataObject|null getLast ( void )

##### public IvoPetkov\DataObject|null getRandom ( void )

##### public IvoPetkov\DataList map ( callable $callback )

##### public IvoPetkov\DataObject|null pop ( void )

##### public IvoPetkov\DataList push ( IvoPetkov\DataObject|array $object )

##### public IvoPetkov\DataList reverse ( void )

##### public IvoPetkov\DataObject|null shift ( void )

##### public IvoPetkov\DataList shuffle ( void )

##### public IvoPetkov\DataList slice ( int $offset [, int $length ] )

##### public IvoPetkov\DataList sliceProperties ( array $properties )

##### public IvoPetkov\DataList sort ( callable $callback )

##### public IvoPetkov\DataList sortBy ( string $property [, string $order = 'asc' ] )

##### public array toArray ( void )

##### public string toJSON ( void )

##### public IvoPetkov\DataList unshift ( IvoPetkov\DataObject|array $object )

## Details

File: /src/DataList.php

---

[back to index](index.md)

