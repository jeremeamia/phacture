<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Factory\ClassFactory;
use Jeremeamia\Phacture\FactoryInterface;

class InitializerDecorator extends BaseDecorator
{
    /**
     * @var array
     */
    protected $initializers = array();

    public function __construct(FactoryInterface $innerFactory = null, $initializers = array())
    {
        $this->innerFactory = $innerFactory ?: new ClassFactory;

        $initializers = (array) $initializers;
        foreach ($initializers as $initializer) {
            $this->addInitializer($initializer);
        }
    }

    /**
     * @param callable $initializer
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function addInitializer($initializer)
    {
        if (is_callable($initializer)) {
            $this->initializers[] = $initializer;
        } else {
            throw new \InvalidArgumentException('The value provided was not a valid callback.');
        }

        return $this;
    }

    public function doCreate($identifier, array $options)
    {
        $instance = $this->innerFactory->create($identifier, $options);

        foreach ($this->initializers as $initializer) {
            $instance = call_user_func($initializer, $instance, $options);
        }

        return $instance;
    }
}
