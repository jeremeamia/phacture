<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Factory\ClassFactory;
use Jeremeamia\Phacture\FactoryInterface;

class ExposeInnerMethodDecorator extends BaseDecorator
{
    /**
     * @var array
     */
    protected $innerMethods;

    /**
     * @param FactoryInterface $innerFactory
     * @param array            $innerMethods
     */
    public function __construct(FactoryInterface $innerFactory = null, array $innerMethods = array())
    {
        $this->innerFactory = $innerFactory ?: new ClassFactory;

        foreach ($innerMethods as $method => $factory) {
            $this->exposeInnerMethod($method, $factory);
        }
    }

    /**
     * @param string           $method
     * @param FactoryInterface $factory
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function exposeInnerMethod($method, FactoryInterface $factory)
    {
        $innerMethod = array($factory, $method);

        if (is_callable($innerMethod)) {
            $this->innerMethods[$method] = $innerMethod;
        } else {
            throw new \InvalidArgumentException('The method that you specified does not exist.');
        }

        return $this;
    }

    public function doCreate($name, array $options)
    {
        return $this->innerFactory->create($this->inflect($name), $options);
    }

    public function __call($method, $args)
    {
        if (isset($this->innerMethods[$method])) {
            return call_user_func_array($this->innerMethods[$method], $args);
        } else {
            throw new \BadMethodCallException("The method \"{$method}\" does not exist.");
        }
    }
}
