<?php

namespace CodeMine\Core;

interface ItemInterface
{
    public function getName(): string;

    public function getPrice(): int;
}
