<?php

namespace CodeMine\Core;

use CodeMine\Collection\ImmutableCollection;
use Countable;
use Iterator;

interface ImmutableCollectionInterface extends Iterator, Countable
{
    public function compare(int $offset1, int $offset2): bool;

    public function addItem(ItemInterface $item): ImmutableCollectionInterface;

    public function deleteItem(int $offset): ImmutableCollectionInterface;

    public function filter(ItemFilterInterface $filter): ImmutableCollectionInterface;

    public function merge(ImmutableCollectionInterface $immutableCollection): ImmutableCollectionInterface;

    public function intersect(ImmutableCollectionInterface $immutableCollection): ImmutableCollectionInterface;

    public function diff(ImmutableCollectionInterface $immutableCollection): ImmutableCollectionInterface;

    public function toArray(): array;

    public function sortByPrice(): ImmutableCollectionInterface;

    public function sortByName(): ImmutableCollectionInterface;
}
