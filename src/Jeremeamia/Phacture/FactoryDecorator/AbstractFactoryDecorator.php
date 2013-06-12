<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Factory\FactoryInterface;

abstract class AbstractFactoryDecorator implements FactoryInterface
{
    /**
     * @var FactoryInterface
     */
    protected $innerFactory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->innerFactory = $factory;
    }

    public function create($name, $options = array())
    {
        return $this->innerFactory->create($name, $options);
    }

    public function canCreate($name, $options = array())
    {
        return $this->innerFactory->canCreate($name, $options);
    }

    /**
     * @return FactoryInterface
     */
    public function getInnerFactory()
    {
        return $this->innerFactory;
    }

    /**
     * {@inheritdoc}
     * @throws \BadMethodCallException If the method does not exist on the object or decorated object
     */
    public function __call($method, $args)
    {
        $callable = array($this->innerFactory, $method);
        if (is_callable($callable)) {
            return call_user_func_array($callable, $args);
        } else {
            throw new \BadMethodCallException("The \"{$method}\" method does not exist on this object or any of the "
                . "inner (decorated) objects.");
        }
    }

    public function __invoke($name, $options = array())
    {
        return $this->innerFactory->create($name, $options);
    }
}
