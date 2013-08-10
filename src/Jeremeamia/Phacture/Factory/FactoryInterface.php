<?php

namespace Jeremeamia\Phacture\Factory;
use Jeremeamia\Phacture\FactoryException;

/**
 * Generic interface for factory classes.
 */
interface FactoryInterface
{
    /**
     * Create and return an object referenced by an identifier
     *
     * @param mixed $identifier Identifier representing the object to create
     * @param mixed $options    Options for the object creation
     *
     * @throws FactoryException if the identified object cannot be created
     * @return mixed The object that is instantiated
     */
    public function create($identifier, $options = []);

    /**
     * Checks if the identified object can be created by the factory
     *
     * @param mixed $identifier Identifier representing the object to be created
     *
     * @return bool Whether or not the object can be created
     */
    public function canCreate($identifier);
}
