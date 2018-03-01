<?php

namespace CodeMine\Collection;

use CodeMine\Core\ImmutableCollectionInterface;
use CodeMine\Core\ItemFilterInterface;
use CodeMine\Core\ItemInterface;
use InvalidArgumentException;
use SplFixedArray;

class ImmutableCollection implements ImmutableCollectionInterface
{
    /**
     * @var SplFixedArray
     */
    private $elements;

    public function __construct(SplFixedArray $immutable)
    {
        $this->initCollection($immutable);
    }

    public function compare(int $offset1, int $offset2): bool
    {
        if (!$this->elements->offsetExists($offset1) || !$this->elements->offsetExists($offset2)) {
            throw new InvalidArgumentException('Invalid offset set and cannot compare');
        }

        /** @var ItemInterface $element1 */
        $element1 = $this->elements->offsetGet($offset1);
        /** @var ItemInterface $element2 */
        $element2 = $this->elements->offsetGet($offset2);

        return $element1->getPrice() === $element2->getPrice() && $element1->getName() === $element2->getName();
    }

    public function addItem(ItemInterface $item): ImmutableCollectionInterface
    {
        $newCount = $this->count() + 1;
        $immutable = clone $this->elements;
        $immutable->setSize($newCount);
        $immutable[$newCount-1] = $item;

        return new static($immutable);
    }

    public function deleteItem(int $offset): ImmutableCollectionInterface
    {
        $immutable = clone $this->elements;

        if (!$immutable->offsetExists($offset)) {
            throw new InvalidArgumentException('Offset to delete is not found');
        }

        $immutable->offsetUnset($offset);
        $array = array_values(array_filter($immutable->toArray()));

        return new static(SplFixedArray::fromArray($array));
    }

    public function filter(ItemFilterInterface $filter): ImmutableCollectionInterface
    {
        $filtered = [];

        foreach ($this->elements as $item) {
            if ($filter->itemIsCompatibleWithFilter($item)) {
                $filtered[] = $item;
            }
        }

        return new static(SplFixedArray::fromArray($filtered));
    }

    public function merge(ImmutableCollectionInterface $immutableCollection): ImmutableCollectionInterface
    {
        $initialCollection = clone $this->elements;
        $merged = array_unique(array_merge($initialCollection->toArray(), $immutableCollection->toArray()));

        return new static(SplFixedArray::fromArray(array_values($merged)));
    }

    public function intersect(ImmutableCollectionInterface $immutableCollection): ImmutableCollectionInterface
    {
        $initialCollection = clone $this->elements;
        $merged = array_intersect($initialCollection->toArray(), $immutableCollection->toArray());

        return new static(SplFixedArray::fromArray($merged));
    }

    public function diff(ImmutableCollectionInterface $immutableCollection): ImmutableCollectionInterface
    {
        $initialCollection = clone $this->elements;
        $merged = array_diff($initialCollection->toArray(), $immutableCollection->toArray());

        return new static(SplFixedArray::fromArray($merged));
    }

    public function toArray(): array
    {
        return $this->elements->toArray();
    }

    public function count()
    {
        return $this->elements->count();
    }

    public function current()
    {
       return $this->elements->current();
    }

    public function next()
    {
        $this->elements->next();
    }

    public function key()
    {
        return $this->elements->key();
    }

    public function valid()
    {
        return $this->elements->valid();
    }

    public function rewind()
    {
        $this->elements->rewind();
    }

    private function initCollection(SplFixedArray $immutable)
    {
        $this->checkCollection($immutable);
        $this->elements = $immutable;
    }

    private function checkCollection(SplFixedArray $immutable): void
    {
        foreach ($immutable as $key => $element) {
            if (!$element instanceof ItemInterface) {
                throw new InvalidArgumentException('Item is not implementing ItemInterface');
            }
        }
    }
}
