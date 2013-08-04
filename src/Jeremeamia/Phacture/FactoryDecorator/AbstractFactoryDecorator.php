<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Factory\AliasFactoryInterface;
use Jeremeamia\Phacture\Factory\AliasFactoryTrait;

abstract class AbstractFactoryDecorator implements FactoryDecoratorInterface
{
    use AliasFactoryTrait;

    /**
     * @var AliasFactoryInterface
     */
    protected $innerFactory;

    /**
     * @param AliasFactoryInterface $factory
     */
    public function __construct(AliasFactoryInterface $factory)
    {
        $this->innerFactory = $factory;
    }

    public function create($name, $options = [])
    {
        return $this->innerFactory->create($name, $options);
    }

    public function canCreate($name)
    {
        return $this->innerFactory->canCreate($name);
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
