<?php

namespace Domain;

class CoffeeItemCollection
{
    private array $items = [];

    public function add(CoffeeItem $item)
    {
        $this->items[] = $item;
    }
}
