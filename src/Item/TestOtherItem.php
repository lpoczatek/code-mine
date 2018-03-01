<?php

namespace CodeMine\Item;

use CodeMine\Core\AbstractItem;

class TestOtherItem extends AbstractItem
{
    public function getName(): string
    {
        return 'testOther';
    }

    public function getPrice(): int
    {
        return 25;
    }
}
