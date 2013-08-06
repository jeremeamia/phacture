<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Factory\FactoryInterface;
use Jeremeamia\Phacture\Factory\FactoryTrait;

abstract class AbstractFactoryDecorator implements FactoryDecoratorInterface
{
    use FactoryTrait;

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

    public function create($identifier, $options = [])
    {
        return $this->innerFactory->create($identifier, $options);
    }

    public function canCreate($identifier)
    {
        return $this->innerFactory->canCreate($identifier);
    }

    public function getInnerFactory()
    {
        return $this->innerFactory;
    }

    public function __call($method, $args)
    {
        return call_user_func_array(array($this->innerFactory, $method), $args);
    }
}
