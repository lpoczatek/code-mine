<?php

require __DIR__.'/../autoload.php';

use CodeMine\Collection\ImmutableCollection;
use CodeMine\Filter\CollectionFilter;
use CodeMine\Item\TestAnotherItem;
use CodeMine\Item\TestItem;
use CodeMine\Item\TestOtherItem;
use PHPUnit\Framework\TestCase;

class ImmutableCollectionTest extends TestCase
{
    public function testCanBeCreatedFromValidCollection()
    {
        $splFixedArray = new SplFixedArray(3);
        $splFixedArray[0] = new TestItem();
        $splFixedArray[1] = new TestItem();
        $splFixedArray[2] = new TestItem();

        $this->assertInstanceOf(
            ImmutableCollection::class,
            new ImmutableCollection($splFixedArray)
        );
    }

    public function testCompareTwoItemsInCollection()
    {
        $splFixedArray = new SplFixedArray(3);
        $splFixedArray[0] = new TestItem();
        $splFixedArray[1] = new TestItem();
        $splFixedArray[2] = new TestItem();

        $collection = new ImmutableCollection($splFixedArray);

        $this->assertTrue($collection->compare(0,0));
        $this->assertFalse($collection->compare(0,1));
    }

    public function testAddItemToCollection()
    {
        $splFixedArray = new SplFixedArray(1);
        $splFixedArray[0] = new TestItem();

        $collection = new ImmutableCollection($splFixedArray);
        $newCollection = $collection->addItem(new TestAnotherItem());

        $this->assertInstanceOf(
            ImmutableCollection::class,
            $newCollection
        );

        $this->assertCount(1, $collection);
        $this->assertCount(2, $newCollection);
    }

    public function testDeleteItemFromCollection()
    {
        $splFixedArray = new SplFixedArray(2);
        $splFixedArray[0] = new TestItem();
        $splFixedArray[1] = new TestItem();

        $collection = new ImmutableCollection($splFixedArray);
        $newCollection = $collection->deleteItem(1);

        $this->assertInstanceOf(
            ImmutableCollection::class,
            $newCollection
        );

        $this->assertCount(2, $collection);
        $this->assertCount(1, $newCollection);
    }

    public function testFilterCollection()
    {
        $splFixedArray = new SplFixedArray(2);
        $splFixedArray[0] = new TestItem();
        $splFixedArray[1] = new TestAnotherItem();

        $filter = new CollectionFilter(22, 'test');

        $collection = new ImmutableCollection($splFixedArray);
        $newCollection = $collection->filter($filter);

        $this->assertInstanceOf(
            ImmutableCollection::class,
            $newCollection
        );

        $this->assertCount(2, $collection);
        $this->assertCount(1, $newCollection);
        $this->assertEquals(new TestItem(), $newCollection->toArray()[0]);
    }

    public function testMergeCollection()
    {
        $splFixedArray = new SplFixedArray(3);
        $splFixedArray[0] = new TestItem();
        $splFixedArray[1] = new TestAnotherItem();
        $splFixedArray[2] = new TestItem();

        $collection = new ImmutableCollection($splFixedArray);
        $collection2 = new ImmutableCollection($splFixedArray);
        $newCollection = $collection->merge($collection2);

        $expectedArray = new SplFixedArray(2);
        $expectedArray[0] = new TestItem();
        $expectedArray[1] = new TestAnotherItem();

        $this->assertInstanceOf(
            ImmutableCollection::class,
            $newCollection
        );
        $this->assertEquals(new ImmutableCollection($expectedArray), $newCollection);
    }

    public function testIntersectCollection()
    {
        $splFixedArray = new SplFixedArray(3);
        $splFixedArray[0] = new TestItem();
        $splFixedArray[1] = new TestAnotherItem();
        $splFixedArray[2] = new TestItem();

        $splFixedArray1 = new SplFixedArray(3);
        $splFixedArray1[0] = new TestItem();
        $splFixedArray1[1] = new TestOtherItem();
        $splFixedArray1[2] = new TestItem();

        $collection = new ImmutableCollection($splFixedArray);
        $collection2 = new ImmutableCollection($splFixedArray1);
        $newCollection = $collection->intersect($collection2);

        $expectedArray = new SplFixedArray(2);
        $expectedArray[0] = new TestItem();
        $expectedArray[1] = new TestItem();

        $this->assertInstanceOf(
            ImmutableCollection::class,
            $newCollection
        );
        $this->assertEquals(new ImmutableCollection($expectedArray), $newCollection);
    }

    public function testDiffWithoutDifferencesCollection()
    {
        $splFixedArray = new SplFixedArray(3);
        $splFixedArray[0] = new TestItem();
        $splFixedArray[1] = new TestAnotherItem();
        $splFixedArray[2] = new TestItem();

        $collection = new ImmutableCollection($splFixedArray);
        $collection2 = new ImmutableCollection($splFixedArray);
        $newCollection = $collection->diff($collection2);

        $expectedArray = new SplFixedArray(0);

        $this->assertInstanceOf(
            ImmutableCollection::class,
            $newCollection
        );
        $this->assertEquals(new ImmutableCollection($expectedArray), $newCollection);
    }

    public function testDiffCollection()
    {
        $splFixedArray = new SplFixedArray(3);
        $splFixedArray[0] = new TestItem();
        $splFixedArray[1] = new TestAnotherItem();
        $splFixedArray[2] = new TestItem();

        $splFixedArray1 = new SplFixedArray(2);
        $splFixedArray1[0] = new TestItem();
        $splFixedArray1[1] = new TestOtherItem();

        $collection = new ImmutableCollection($splFixedArray);
        $collection2 = new ImmutableCollection($splFixedArray1);
        $newCollection = $collection->diff($collection2);

        $expectedArray = new SplFixedArray(1);
        $expectedArray[0] = new TestAnotherItem();

        $this->assertInstanceOf(
            ImmutableCollection::class,
            $newCollection
        );
        $this->assertEquals(new ImmutableCollection($expectedArray), $newCollection);
    }

    public function testToArray()
    {
        $splFixedArray = new SplFixedArray(2);
        $splFixedArray[0] = new TestItem();
        $splFixedArray[1] = new TestAnotherItem();

        $collection = new ImmutableCollection($splFixedArray);
        $array = $collection->toArray();

        $this->assertArrayHasKey(0, $array);
        $this->assertArrayHasKey(1, $array);
    }

    public function testCount()
    {
        $splFixedArray = new SplFixedArray(2);
        $splFixedArray[0] = new TestItem();
        $splFixedArray[1] = new TestAnotherItem();

        $collection = new ImmutableCollection($splFixedArray);

        $this->assertCount(2, $collection);
    }

    public function testIsIterable()
    {
        $splFixedArray = new SplFixedArray(2);
        $splFixedArray[0] = new TestItem();
        $splFixedArray[1] = new TestAnotherItem();

        $collection = new ImmutableCollection($splFixedArray);
        $result = [];

        foreach ($collection as $item) {
            $result[] = $item;
        }

        $this->assertCount(2, $result);
    }

    public function testSortByName()
    {
        $splFixedArray = new SplFixedArray(2);
        $splFixedArray[0] = new TestItem();
        $splFixedArray[1] = new TestAnotherItem();

        $collection = new ImmutableCollection($splFixedArray);
        $newCollection = $collection->sortByName();

        $expectedArray = new SplFixedArray(2);
        $expectedArray[0] = new TestAnotherItem();
        $expectedArray[1] = new TestItem();

        $expectedCollection = new ImmutableCollection($expectedArray);

        $this->assertEquals($expectedCollection, $newCollection);
    }

    public function testSortByPrice()
    {
        $splFixedArray = new SplFixedArray(2);
        $splFixedArray[0] = new TestItem();
        $splFixedArray[1] = new TestAnotherItem();

        $collection = new ImmutableCollection($splFixedArray);
        $newCollection = $collection->sortByPrice();

        $expectedArray = new SplFixedArray(2);
        $expectedArray[0] = new TestAnotherItem();
        $expectedArray[1] = new TestItem();

        $expectedCollection = new ImmutableCollection($expectedArray);

        $this->assertEquals($expectedCollection, $newCollection);
    }
}
