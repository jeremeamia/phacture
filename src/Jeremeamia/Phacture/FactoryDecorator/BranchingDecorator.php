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

    public function doCreate($name, array $options)
    {
        try {
            return $this->innerFactory->create($name, $options);
        } catch (FactoryException $e) {
            return $this->alternateFactory->create($name, $options);
        }
    }
}
