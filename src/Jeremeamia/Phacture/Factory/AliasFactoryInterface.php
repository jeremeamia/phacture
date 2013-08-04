<?php

namespace Jeremeamia\Phacture\Factory;

/**
 * Generic interface for factory classes.
 */
interface AliasFactoryInterface
{
    /**
     * Create and return an object referenced by a name or identifier
     *
     * @param mixed $name    Name or identifier representing the object to create
     * @param mixed $options Options for the object creation
     *
     * @throws FactoryException Throws FactoryException if the identified object cannot be created
     * @return mixed The object that is instantiated
     */
    public function create($name, $options = []);

    /**
     * Checks if the identified object can be created by the factory
     *
     * @param mixed $name Name or identifier representing the object to be created
     *
     * @return bool Whether or not the object can be created
     */
    public function canCreate($name);
}
