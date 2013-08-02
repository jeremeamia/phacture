<?php

namespace Jeremeamia\Phacture\Factory;

/**
 * Trait for factories that must determine the FQCN from the provided name
 */
trait ClassFactoryTrait
{
    use FactoryTrait;

    public function create($name, $options = [])
    {
        $options = $this->convertOptionsToArray($options);

        if ($fqcn = $this->getFullyQualifiedClassName($name, $options)) {
            return $this->instantiateClass($fqcn, $options);
        } else {
            throw (new FactoryException)->setName($name)->setOptions($options);
        }
    }

    public function canCreate($name, $options = [])
    {
        $options = $this->convertOptionsToArray($options);

        return (bool) $this->getFullyQualifiedClassName($name, $options);
    }

    /**
     * Performs the actual object creation work. This method is meant to be overwritten to perform more specific logic
     *
     * @param string $fqcn    Fully qualified class name (FQCN) of the class to instantiate
     * @param array  $options Options for the object creation
     *
     * @return mixed
     */
    protected function instantiateClass($fqcn, array $options)
    {
        return new $fqcn;
    }

    /**
     * Determines the fully qualified class name (FQCN) of a class based on a provided name
     *
     * @param string $name    Name representing the object to create
     * @param array  $options Options for the object creation
     *
     * @return null|string
     */
    abstract protected function getFullyQualifiedClassName($name, array $options);
}
