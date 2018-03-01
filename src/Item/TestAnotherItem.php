<?php

namespace CodeMine\Item;

use CodeMine\Core\AbstractItem;

class TestAnotherItem extends AbstractItem
{
    public function getName(): string
    {
        return 'another test another';
    }

    public function getPrice(): int
    {
        return 20;
    }
}
