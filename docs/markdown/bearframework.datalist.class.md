# BearFramework\DataList

extends IvoPetkov\DataList

implements [Traversable](http://php.net/manual/en/class.traversable.php), [Iterator](http://php.net/manual/en/class.iterator.php), [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

Base class for lists.

## Methods

### Inherited from IvoPetkov\DataList:

##### public [__construct](ivopetkov.datalist.__construct.method.md) ( [ array|iterable|callback $dataSource ] )

##### public \IvoPetkov\DataList [concat](ivopetkov.datalist.concat.method.md) ( \IvoPetkov\DataList $list )

##### public \IvoPetkov\DataList [filter](ivopetkov.datalist.filter.method.md) ( callable $callback )

##### public \IvoPetkov\DataList [filterBy](ivopetkov.datalist.filterby.method.md) ( string $property , mixed $value [, string $operator = 'equal' ] )

##### public \IvoPetkov\DataObject|null [get](ivopetkov.datalist.get.method.md) ( int $index )

##### public \IvoPetkov\DataObject|null [getFirst](ivopetkov.datalist.getfirst.method.md) ( void )

##### public \IvoPetkov\DataObject|null [getLast](ivopetkov.datalist.getlast.method.md) ( void )

##### public \IvoPetkov\DataObject|null [getRandom](ivopetkov.datalist.getrandom.method.md) ( void )

##### public \IvoPetkov\DataList [map](ivopetkov.datalist.map.method.md) ( callable $callback )

##### public \IvoPetkov\DataObject|null [pop](ivopetkov.datalist.pop.method.md) ( void )

##### public \IvoPetkov\DataList [push](ivopetkov.datalist.push.method.md) ( \IvoPetkov\DataObject|array $object )

##### public \IvoPetkov\DataList [reverse](ivopetkov.datalist.reverse.method.md) ( void )

##### public \IvoPetkov\DataObject|null [shift](ivopetkov.datalist.shift.method.md) ( void )

##### public \IvoPetkov\DataList [shuffle](ivopetkov.datalist.shuffle.method.md) ( void )

##### public \IvoPetkov\DataList [slice](ivopetkov.datalist.slice.method.md) ( int $offset [, int $length ] )

##### public \IvoPetkov\DataList [sliceProperties](ivopetkov.datalist.sliceproperties.method.md) ( array $properties )

##### public \IvoPetkov\DataList [sort](ivopetkov.datalist.sort.method.md) ( callable $callback )

##### public \IvoPetkov\DataList [sortBy](ivopetkov.datalist.sortby.method.md) ( string $property [, string $order = 'asc' ] )

##### public array [toArray](ivopetkov.datalist.toarray.method.md) ( void )

##### public string [toJSON](ivopetkov.datalist.tojson.method.md) ( void )

##### public \IvoPetkov\DataList [unshift](ivopetkov.datalist.unshift.method.md) ( \IvoPetkov\DataObject|array $object )

## Details

File: /src/DataList.php

---

[back to index](index.md)

