<?php

namespace Jeremeamia\Phacture\Factory;

trait FactoryMapFactoryTrait
{
    use FactoryTrait;

    /**
     * @var array
     */
    protected $factories = [];

    /**
     * @param string $identifier
     * @param mixed  $factory
     *
     * @return self
     */
    public function addFactory($identifier, $factory)
    {
        $this->factories[$identifier] = $factory;

        return $this;
    }

    /**
     * @param string $identifier
     *
     * @return self
     */
    public function removeFactory($identifier)
    {
        unset($this->factories[$identifier]);

        return $this;
    }

    public function create($identifier, $options = [])
    {
        $options = $this->convertOptionsToArray($options);

        if (!isset($this->factories[$identifier])) {
            throw (new FactoryException("The factory class for {$identifier} was not found."))
                ->setIdentifier($identifier)
                ->setOptions($options);
        }

        $factoryFqcn = $this->factories[$identifier];
        if (is_object($factoryFqcn)) {
            $factory = $this->factories[$identifier];
            $factoryFqcn = get_class($factory);
        } elseif (class_exists($factoryFqcn)) {
            $factory = new $factoryFqcn;
        } else {
            throw (new FactoryException("The factory class {$factoryFqcn} does not exist."))
                ->setIdentifier($identifier)
                ->setOptions($options);
        }

        if ($factory instanceof OptionsFactoryInterface) {
            return $factory->create($options);
        } else {
            throw (new FactoryException("The factory class {$factoryFqcn} must implement OptionsFactoryInterface."))
                ->setIdentifier($identifier)
                ->setOptions($options);
        }
    }

    public function canCreate($identifier)
    {
        return isset($this->factories[$identifier]);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->factories);
    }
}



