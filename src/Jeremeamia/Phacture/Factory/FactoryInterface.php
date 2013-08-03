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
     * @param mixed $name    Name or identifying value representing the object to create
     * @param mixed $options Options for the object creation
     *
     * @throws FactoryException Throws FactoryException if the object cannot be created
     * @return mixed The object that was instantiated
     */
    public function create($name = null, $options = array());

    /**
     * Checks if the object specified can be created by the factory
     *
     * @param mixed $name    Name or identifying value representing the object to be created
     * @param mixed $options Options for the object creation
     *
     * @return bool Whether or not the object can be created
     */
    public function canCreate($name = null, $options = array());
}
