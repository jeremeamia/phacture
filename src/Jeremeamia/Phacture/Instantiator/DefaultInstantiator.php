<?php

namespace Jeremeamia\Phacture\Instantiator;

use Jeremeamia\Phacture\Factory\FactoryException;

class DefaultInstantiator implements InstantiatorInterface
{
    public function instantiateClass($fqcn, array $options)
    {
        if (class_exists($fqcn)) {
            return new $fqcn;
        } else {
            throw new FactoryException("The class {$fqcn} does not exist.");
        }
    }
}
