<?php

namespace BookStore\Util;

use ReflectionClass;

trait InternalPropertyAssignTrait
{
    public function assignInternalProperty($object, $property, $value)
    {
        $refl = new ReflectionClass($object);
        $prop = $refl->getProperty($property);
        $prop->setAccessible(true);
        $prop->setValue($object, $value);
        $prop->setAccessible(false);
    }
}
