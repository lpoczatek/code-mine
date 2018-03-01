<?php

namespace CodeMine\Item;

use CodeMine\Core\AbstractItem;

class TestAnotherItem extends AbstractItem
{
    public function getName(): string
    {
        return 'test';
    }

    public function getPrice(): int
    {
        return 20;
    }
}
