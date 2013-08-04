<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\PrioritizedRecursiveArrayIterator;

trait CompositeFactoryTrait
{
    use AliasFactoryTrait;

    /**
     * @var array
     */
    protected $factories = [];

    /**
     * @var \RecursiveIteratorIterator
     */
    protected $iterator;

    /**
     * @param AliasFactoryInterface $factory
     * @param int                   $priority
     *
     * @return self
     */
    public function addFactory(AliasFactoryInterface $factory, $priority = 0)
    {
        if (!isset($this->factories[$priority])) {
            $this->factories[$priority] = [];
        }

        $this->factories[$priority][] = $factory;
        $this->iterator = null;

        return $this;
    }

    public function create($name, $options = [])
    {
        /** @var $factory AliasFactoryInterface */
        foreach ($this->getIterator() as $factory) {
            if ($factory->canCreate($name)) {
                return $factory->create($name, $options);
            }
        }

        throw (new FactoryException)->setName($name)->setOptions($options);
    }

    public function canCreate($name)
    {
        /** @var $factory AliasFactoryInterface */
        foreach ($this->getIterator() as $factory) {
            if ($factory->canCreate($name)) {
                return true;
            }
        }

        return false;
    }

    public function getIterator()
    {
        if (!$this->iterator) {
            $this->iterator = new \RecursiveIteratorIterator(
                new PrioritizedRecursiveArrayIterator($this->factories)
            );
        }

        return $this->iterator;
    }
}
