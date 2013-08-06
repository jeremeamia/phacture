<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\HandlesOptionsTrait;

trait FactoryTrait
{
    use HandlesOptionsTrait;

    /**
     * Allows invocation of the factory to trigger object creation
     *
     * @param mixed $identifier Identifier representing the object to create
     * @param mixed $options    Options for the object creation
     *
     * @return mixed The object that is instantiated
     */
    public function __invoke($identifier, $options = [])
    {
        return $this->create($identifier, $options);
    }

    /**
     * Implements the FactoryInterface::create method
     *
     * @see \Jeremeamia\Phacture\Factory\FactoryInterface::create
     */
    abstract public function create($identifier, $options = []);

    /**
     * Implements the FactoryInterface::canCreate method
     *
     * @see \Jeremeamia\Phacture\Factory\FactoryInterface::canCreate
     */
    abstract public function canCreate($identifier);
}
