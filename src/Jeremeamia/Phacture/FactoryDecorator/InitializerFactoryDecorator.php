<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\OptionsHelper;

class InitializerFactoryDecorator extends AbstractFactoryDecorator
{
    /**
     * @var array
     */
    protected $initializers = array();

    /**
     * @param callable $initializer
     *
     * @return $this
     */
    public function addInitializer(\Closure $initializer)
    {
        $this->initializers[] = $initializer;

        return $this;
    }

    public function create($name, $options = array())
    {
        $options = OptionsHelper::arrayify($options);
        $instance = parent::create($name, $options);

        /** @var $initializer \Closure */
        foreach ($this->initializers as $initializer) {
            $initializer($instance, $options);
        }

        return $instance;
    }
}
