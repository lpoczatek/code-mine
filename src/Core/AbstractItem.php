<?php
namespace CodeMine\Core;

abstract class AbstractItem implements ItemInterface
{
    public function __toString()
    {
        return $this->getName().$this->getPrice();
    }
}
