<?php

namespace Domain;

class CoffeeItemCollectionFactory
{
    public static function createFromArray(array $data): CoffeeItemCollection
    {
        $collection = new CoffeeItemCollection();
        foreach($data as $item) {
            $collection->add(new CoffeeItem());
        }

        return $collection;
    }
}
