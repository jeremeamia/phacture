<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\PrioritizedRecursiveArrayIterator;

class CompositeFactory implements FactoryInterface, \IteratorAggregate
{
    /**
     * @var array
     */
    protected $factories = array();

    /**
     * @var \RecursiveIteratorIterator
     */
    protected $iterator;

    /**
     * @param array $factories
     */
    public function __construct(array $factories = array())
    {
        // Add factories to the composite factory
        foreach ($factories as $factory) {
            $this->addFactory($factory);
        }
    }

    /**
     * @param FactoryInterface $factory
     * @param int              $priority
     *
     * @return self
     */
    public function addFactory(FactoryInterface $factory, $priority = 0)
    {
        if (!isset($this->factories[$priority])) {
            $this->factories[$priority] = array();
        }

        $this->factories[$priority][] = $factory;
        $this->iterator = null;

        return $this;
    }

    /**
     * @return \RecursiveIteratorIterator
     */
    public function getIterator()
    {
        if (!$this->iterator) {
            $this->iterator = new \RecursiveIteratorIterator(new PrioritizedRecursiveArrayIterator($this->factories));
        }

        return $this->iterator;
    }

    /**
     * {@inheritdoc}
     * @throws FactoryException If no factory could instantiate the object
     */
    public function create($name, $options = array())
    {
        /** @var $factory FactoryInterface */
        foreach ($this->getIterator() as $factory) {
            try {
                return $factory->create($name, $options);
            } catch (FactoryException $e) {
                continue;
            }
        }

        throw new FactoryException("There was no factory that could instantiate the object identified by \"{$name}\".");
    }
}
