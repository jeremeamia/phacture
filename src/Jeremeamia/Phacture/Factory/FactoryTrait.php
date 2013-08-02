<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\HandlesOptionsTrait;

/**
 * Base factory trait for factory classes
 */
trait FactoryTrait
{
    use HandlesOptionsTrait;

    /**
     * Allows invocation of the factory to trigger object creation
     *
     * @param string $name    Name of the object to create
     * @param mixed  $options Options for the object creation
     *
     * @return mixed The object that was instantiated
     */
    public function __invoke($name, $options = array())
    {
        return $this->create($name, $options);
    }

    /**
     * Implements the FactoryInterface::create method
     *
     * @see \Jeremeamia\Phacture\Factory\FactoryInterface::create
     */
    abstract public function create($name, $options = array());

    /**
     * Implements the FactoryInterface::canCreate method
     *
     * @see \Jeremeamia\Phacture\Factory\FactoryInterface::canCreate
     */
    abstract public function canCreate($name, $options = array());
}
