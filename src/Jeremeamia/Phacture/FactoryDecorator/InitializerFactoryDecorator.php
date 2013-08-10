<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Factory\FactoryInterface;

class InitializerFactoryDecorator extends AbstractFactoryDecorator
{
    /**
     * @var array
     */
    protected $initializers = [];

    public function __construct(FactoryInterface $factory, $initializers = [])
    {
        $this->innerFactory = $factory;

        $initializers = (array) $initializers;
        foreach ($initializers as $initializer) {
            $this->addInitializer($initializer);
        }
    }

    /**
     * @param callable $initializer
     *
     * @return $this
     */
    public function addInitializer(callable $initializer)
    {
        $this->initializers[] = $initializer;

        return $this;
    }

    public function create($identifier, $options = [])
    {
        $options = $this->prepareOptions($options);
        $instance = $this->innerFactory->create($identifier, $options);

        /** @var callable $initializer */
        foreach ($this->initializers as $initializer) {
            $initializer($instance, $options);
        }

        return $instance;
    }
}
