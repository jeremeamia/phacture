<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\OptionsHelper;

/**
 * Base factory class for factories that must determine the FQCN from the provided name
 */
abstract class AbstractClassFactory implements FactoryInterface
{
    public function create($name, $options = array())
    {
        $options = OptionsHelper::arrayify($options);
        if ($fqcn = $this->getFullyQualifiedClassName($name, $options)) {
            return new $fqcn;
        } else {
            throw new FactoryException("Could not instantiate the class by the name \"{$name}\".");
        }
    }

    public function canCreate($name, $options = array())
    {
        $options = OptionsHelper::arrayify($options);
        return (bool) $this->getFullyQualifiedClassName($name, $options);
    }

    public function __invoke($name, $options = array())
    {
        return $this->create($name, $options);
    }

    /**
     * Determines the fully qualified class name (FQCN) of a class based on a provided name
     *
     * @param string $name    Name of the object to create
     * @param array  $options Options for the object creation
     *
     * @return null|string
     */
    abstract protected function getFullyQualifiedClassName($name, array $options);
}
