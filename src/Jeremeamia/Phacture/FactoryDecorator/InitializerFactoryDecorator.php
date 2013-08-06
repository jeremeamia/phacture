<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

class InitializerFactoryDecorator extends AbstractFactoryDecorator
{
    /**
     * @var array
     */
    protected $initializers = [];

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
        $options = $this->convertOptionsToArray($options);
        $instance = $this->innerFactory->create($identifier, $options);

        /** @var callable $initializer */
        foreach ($this->initializers as $initializer) {
            $initializer($instance, $options);
        }

        return $instance;
    }
}
