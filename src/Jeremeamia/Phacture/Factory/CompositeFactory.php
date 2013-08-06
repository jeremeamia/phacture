<?php

namespace Jeremeamia\Phacture\Factory;

class CompositeFactory implements FactoryInterface, \IteratorAggregate
{
    use CompositeFactoryTrait;

    /**
     * @param array $factories
     */
    public function __construct(array $factories = [])
    {
        // Add factories to the composite factory
        foreach ($factories as $factory) {
            $this->addFactory($factory);
        }
    }
}
