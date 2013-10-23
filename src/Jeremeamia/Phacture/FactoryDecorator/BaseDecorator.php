<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Factory\BaseFactory;
use Jeremeamia\Phacture\Factory\ClassFactory;
use Jeremeamia\Phacture\FactoryInterface;

/**
 *
 */
abstract class BaseDecorator extends BaseFactory
{
    /**
     * @var FactoryInterface
     */
    protected $innerFactory;

    /**
     * @param FactoryInterface $innerFactory
     */
    public function __construct(FactoryInterface $innerFactory = null)
    {
        $this->innerFactory = $innerFactory ?: new ClassFactory;
    }

    /**
     * @param FactoryInterface $innerFactory
     *
     * @return $this
     */
    public function setInnerFactory(FactoryInterface $innerFactory)
    {
        $this->innerFactory = $innerFactory;

        return $this;
    }

    /**
     * @return FactoryInterface
     */
    public function getInnerFactory()
    {
        return $this->innerFactory;
    }

    protected function doCreate($name, array $options)
    {
        return $this->innerFactory->create($name, $options);
    }
}
