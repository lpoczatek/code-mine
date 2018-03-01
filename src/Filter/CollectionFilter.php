<?php

namespace CodeMine\Filter;

use CodeMine\Core\ItemFilterInterface;
use CodeMine\Core\ItemInterface;

class CollectionFilter implements ItemFilterInterface
{
    private $price;

    private $name;

    public function __construct($price = null, $name = null)
    {
        $this->price = $price;
        $this->name = $name;
    }

    public function itemIsCompatibleWithFilter(ItemInterface $item): bool
    {
        if ($this->name !== null && $this->price !== null) {
            return $item->getName() === $this->name && $item->getPrice() === $this->price;
        }

        if ($this->name !== null)  {
            return $item->getName() === $this->name;
        }

        if ($this->price !== null)  {
            return $item->getPrice() === $this->price;
        }

        return false;
    }
}
