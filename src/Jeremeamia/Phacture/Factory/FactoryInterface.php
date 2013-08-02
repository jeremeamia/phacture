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
     * @param string $name    Name representing the object to create
     * @param mixed  $options Options for the object creation
     *
     * @throws FactoryException Throws FactoryException if the object cannot be created
     * @return mixed The object that was instantiated
     */
    public function create($name, $options = array());

    /**
     * Checks if the object specified can be created by the factory
     *
     * @param string             $name    Name representing the object to be created
     * @param array|\Traversable $options Options for the object creation
     *
     * @return bool Whether or not the object can be created
     */
    public function canCreate($name, $options = array());
}
