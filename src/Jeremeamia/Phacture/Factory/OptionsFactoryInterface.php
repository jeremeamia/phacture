<?php

namespace Jeremeamia\Phacture\Factory;

/**
 * Generic interface for factory classes.
 */
interface OptionsFactoryInterface
{
    /**
     * Create and return an object specified by a name.
     *
     * @param mixed $options Options for the object creation
     *
     * @throws FactoryException Throws FactoryException if the object cannot be created
     * @return mixed The object that was instantiated
     */
    public function create($options = []);
}
