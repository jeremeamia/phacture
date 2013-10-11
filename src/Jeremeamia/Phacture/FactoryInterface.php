<?php

namespace Jeremeamia\Phacture;

use Jeremeamia\Phacture\FactoryException;

/**
 * Generic interface for factory classes.
 */
interface FactoryInterface
{
    /**
     * Create and return an object referenced by an name
     *
     * @param string $name Name representing the object to create
     * @param array $options     Options for the object creation
     *
     * @return mixed The object that is instantiated
     * @throws FactoryException if the identified object cannot be created
     */
    public function create($name, array $options = array());

    /**
     * Checks if the identified object can be created by the factory
     *
     * @param string $name Name representing the object to be created
     *
     * @return bool Whether or not the object can be created
     */
    public function canCreate($name);
}
