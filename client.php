<?php

namespace CodeMine;
require __DIR__.'/autoload.php';

use CodeMine\Collection\ImmutableCollection;
use CodeMine\Filter\CollectionFilter;
use CodeMine\Item\TestAnotherItem;
use CodeMine\Item\TestItem;
use CodeMine\Item\TestOtherItem;
use SplFixedArray;

$item1 = new TestItem();
$item2 = new TestAnotherItem();
$item3 = new TestOtherItem();
$item4 = new TestItem();

$traversable = new SplFixedArray(3);
$traversable[0] = $item1;
$traversable[1] = $item2;
$traversable[2] = $item3;

$collection = new ImmutableCollection($traversable);
$collection = $collection->addItem($item4);
$collection = $collection->deleteItem(1);
print '<pre>';
var_dump($collection->compare(0,2)); // true
var_dump($collection->compare(1,2)); // false

$filteredCollection = $collection->filter(new CollectionFilter(20, 'test'));
print 'Filtered Collection ';
print_r($filteredCollection->toArray());

$newCollection = new ImmutableCollection($traversable);
$result = $newCollection->merge($collection);
print 'Merged Collection ';
print_r($result->toArray());

$collection = new ImmutableCollection($traversable);
$newCollection = new ImmutableCollection($traversable);
$result = $newCollection->intersect($collection);
print 'Intersected Collection ';
print_r($result->toArray());

$collection = new ImmutableCollection($traversable);
$newCollection = new ImmutableCollection($traversable);
$result = $newCollection->diff($collection);
print 'Differentiated  Collection ';
print_r($result->toArray());
