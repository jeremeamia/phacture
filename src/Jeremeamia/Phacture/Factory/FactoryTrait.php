<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\OptionsHelper;

/**
 * Base factory trait for factory classes
 */
trait FactoryTrait
{
    /**
     * Allows invocation of the factory to trigger object creation
     *
     * @param string             $name    Name of the object to create
     * @param array|\Traversable $options Options for the object creation
     *
     * @return mixed The object that was instantiated
     */
    public function __invoke($name, $options = array())
    {
        return $this->create($name, $options);
    }

    /**
     * Create and return an object specified by a name.
     *
     * @param string             $name    Name of the object to create
     * @param array|\Traversable $options Options for the object creation
     *
     * @return mixed The object that was instantiated
     * @throws FactoryException Throws FactoryException if the object referenced by the provided name cannot be created
     */
    abstract public function create($name, $options = array());

    /**
     * Checks if the object specified can be created by the factory
     *
     * @param string             $name    Name of the object to be create created
     * @param array|\Traversable $options Options for the object creation
     *
     * @return bool Whether or not the object can be created
     */
    abstract public function canCreate($name, $options = array());

    /**
     * Coerces the provided argument into an array
     *
     * @param mixed $options
     *
     * @return array
     */
    protected static function arrayifyOptions($options)
    {
        return OptionsHelper::arrayify($options);
    }
}
