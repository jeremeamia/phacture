<?php

namespace Jeremeamia\Phacture\Instantiator;

class DefaultInstantiator implements InstantiatorInterface
{
    public function instantiateClass($fqcn, array $options)
    {
        return new $fqcn;
    }
}
