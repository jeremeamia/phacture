<?php

namespace Jeremeamia\Phacture\Factory;

/**
 * Generic interface for factory classes.
 */
interface FactoryInterface
{
    /**
     * Create and return an object specified by a name.
     *
     * @param string             $name    Name of the object to create
     * @param array|\Traversable $options Options for the object creation
     *
     * @return mixed The object that was instantiated
     * @throws FactoryException Throws FactoryException if the object referenced by the provided name cannot be created
     */
    public function create($name, $options = array());

    /**
     * Checks if the object specified can be created by the factory
     *
     * @param string             $name    Name of the object to be create created
     * @param array|\Traversable $options Options for the object creation
     *
     * @return bool Whether or not the object can be created
     */
    public function canCreate($name, $options = array());
}
