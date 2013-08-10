<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\FactoryException;
use Jeremeamia\Phacture\PrioritizedRecursiveArrayIterator;

trait CompositeFactoryTrait
{
    use FactoryTrait;

    /**
     * @var array
     */
    protected $factories = [];

    /**
     * @var \RecursiveIteratorIterator
     */
    protected $iterator;

    /**
     * @param FactoryInterface $factory
     * @param int              $priority
     *
     * @return self
     */
    public function addFactory(FactoryInterface $factory, $priority = 0)
    {
        if (!isset($this->factories[$priority])) {
            $this->factories[$priority] = [];
        }

        $this->factories[$priority][] = $factory;
        $this->iterator = null;

        return $this;
    }

    public function create($identifier, $options = [])
    {
        /** @var $factory FactoryInterface */
        foreach ($this->getIterator() as $factory) {
            if ($factory->canCreate($identifier)) {
                return $factory->create($identifier, $options);
            }
        }

        throw (new FactoryException)->setContext($identifier, $options);
    }

    public function canCreate($identifier)
    {
        /** @var $factory FactoryInterface */
        foreach ($this->getIterator() as $factory) {
            if ($factory->canCreate($identifier)) {
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

    public function __call($method, $args)
    {
        foreach ($this->getIterator() as $factory) {
            try {
                $callable = [$factory, $method];
                if (is_callable($callable)) {
                    return call_user_func_array($callable, $args);
                }
            } catch (\BadMethodCallException $e) {
                continue;
            }
        }

        throw new \BadMethodCallException("The {$method} method did not exist on this or any inner factory objects.");
    }
}
