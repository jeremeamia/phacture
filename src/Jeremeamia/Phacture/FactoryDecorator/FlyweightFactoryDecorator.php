<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\OptionsHelper;

class FlyweightFactoryDecorator extends AbstractFactoryDecorator
{
    /**
     * @var array
     */
    protected $objects = array();

    /**
     * {@inheritdoc}
     */
    public function create($name, $options = array())
    {
        $options = OptionsHelper::arrayify($options);
        $key = $this->calculateKey($name, $options);

        if (isset($options['use_new']) && $options['use_new']) {
            unset($this->objects[$key], $options['use_new']);
        }

        if (!isset($this->objects[$key])) {
            $this->objects[$key] = parent::create($name, $options);
        }

        return $this->objects[$key];
    }

    /**
     * Clears the cache of objects that the flyweight factory has stored
     *
     * @return self
     */
    public function clear()
    {
        $this->objects = array();

        return $this;
    }

    /**
     * Determines the key used to cache the objects. This should be overridden if more complex logic is required
     *
     * @param string $name
     * @param array  $options
     *
     * @return string
     */
    protected function calculateKey($name, array $options)
    {
        return $name;
    }
}
