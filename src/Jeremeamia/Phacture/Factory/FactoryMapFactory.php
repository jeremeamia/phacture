<?php

namespace Jeremeamia\Phacture\Factory;

class FactoryMapFactory implements FactoryInterface, \IteratorAggregate
{
    use FactoryMapFactoryTrait;

    public function __construct(array $factories = [])
    {
        foreach ($factories as $identifier => $factory) {
            $this->addFactory($identifier, $factory);
        }
    }
}



