<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Factory\BaseFactory;
use Jeremeamia\Phacture\FactoryException;
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

    public function setInnerFactory(FactoryInterface $innerFactory)
    {
        $this->innerFactory = $innerFactory;

        return $this;
    }
}
