<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\HandlesOptionsTrait;

trait AliasFactoryTrait
{
    use HandlesOptionsTrait;

    /**
     * Allows invocation of the factory to trigger object creation
     *
     * @param mixed $name    Name or identifier representing the object to create
     * @param mixed $options Options for the object creation
     *
     * @return mixed The object that is instantiated
     */
    public function __invoke($name, $options = [])
    {
        return $this->create($name, $options);
    }

    /**
     * Implements the FactoryInterface::create method
     *
     * @see \Jeremeamia\Phacture\Factory\AliasFactoryInterface::create
     */
    abstract public function create($name, $options = []);

    /**
     * Implements the FactoryInterface::canCreate method
     *
     * @see \Jeremeamia\Phacture\Factory\AliasFactoryInterface::canCreate
     */
    abstract public function canCreate($name);
}
