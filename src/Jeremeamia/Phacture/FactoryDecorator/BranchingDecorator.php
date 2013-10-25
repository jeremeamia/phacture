<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\FactoryException;
use Jeremeamia\Phacture\FactoryInterface;

class BranchingDecorator extends BaseDecorator
{
    /**
     * @var FactoryInterface
     */
    protected $alternateFactory;

    public function __construct(FactoryInterface $innerFactory, FactoryInterface $alternateFactory)
    {
        $this->innerFactory = $innerFactory;
        $this->alternateFactory = $alternateFactory;
    }

    /**
     * @return FactoryInterface
     */
    public function getAlternateFactory()
    {
        return $this->alternateFactory;
    }

    protected function doCreate($name, array $options)
    {
        try {
            return $this->innerFactory->create($name, $options);
        } catch (FactoryException $e) {
            return $this->alternateFactory->create($name, $options);
        }
    }

    public function __call($method, $args)
    {
        try {
            return parent::__call($method, $args);
        } catch (\BadMethodCallException $e) {
            return call_user_func_array(array($this->alternateFactory, $method), $args);
        }
    }
}
