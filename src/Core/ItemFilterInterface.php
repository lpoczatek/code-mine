<?php

namespace CodeMine\Core;

interface ItemFilterInterface
{
    public function itemIsCompatibleWithFilter(ItemInterface $item): bool;
}
