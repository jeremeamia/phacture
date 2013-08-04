<?php

namespace Jeremeamia\Phacture\Instantiator;

use Jeremeamia\Phacture\Factory\FactoryException;
use Jeremeamia\Phacture\Factory\OptionsFactoryInterface;

class FactoryMapInstantiator implements InstantiatorInterface
{
    /**
     * @var array
     */
    private $factories = [];

    /**
     * @param string                         $class
     * @param string|OptionsFactoryInterface $factory
     *
     * @throws \InvalidArgumentException
     * @return self
     */
    public function addFactory($class, $factory)
    {
        if (is_string($factory) || $factory instanceof OptionsFactoryInterface) {
            $this->factories[$class] = $factory;
        } else {
            throw new \InvalidArgumentException('You must provide an instance of OptionsFactoryInterface or a FQCN.');
        }

        return $this;
    }

    /**
     * @param string $class
     *
     * @return self
     */
    public function removeFactory($class)
    {
        unset($this->factories[$class]);

        return $this;
    }

    public function instantiateClass($fqcn, array $options)
    {
        if (!isset($this->factories[$fqcn])) {
            throw new FactoryException("The factory class for {$fqcn} was not found.");
        }

        $factoryFqcn = $this->factories[$fqcn];
        if (is_object($factoryFqcn)) {
            $factory = $this->factories[$fqcn];
            $factoryFqcn = get_class($factory);
        } elseif (class_exists($factoryFqcn)) {
            $factory = new $factoryFqcn;
        } else {
            throw new FactoryException("The factory class {$factoryFqcn} does not exist.");
        }

        if ($factory instanceof OptionsFactoryInterface) {
            return $factory->create($options);
        } else {
            throw new FactoryException("The factory class {$factoryFqcn} must implement OptionsFactoryInterface.");
        }
    }
}
