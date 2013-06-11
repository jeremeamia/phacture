<?php

namespace Jeremeamia\Phacture;

use Jeremeamia\Phacture\Factory\CallbackFactory;
use Jeremeamia\Phacture\FactoryDecorator\FlyweightFactoryDecorator;

class Container implements \ArrayAccess, \IteratorAggregate
{
    /** @var array */
    protected $config;

    /** @var CallbackFactory */
    protected $factory;

    /**
     * @param array|\Traversable    $config
     * @param CallbackFactory|null $factory
     */
    public function __construct($config = array(), CallbackFactory $factory = null)
    {
        $this->config = OptionsHelper::arrayify($config);
        $this->factory = new FlyweightFactoryDecorator($factory ?: new CallbackFactory());
    }

    /**
     * @param string                  $name
     * @param array|\Traversable|null $options
     *
     * @return mixed
     */
    public function get($name, $options = null)
    {
        if (array_key_exists($name, $this->config)) {
            return $this->config[$name];
        }

        if ($options) {
            $options = OptionsHelper::arrayify($options);
            $options['use_new'] = true;
        } else {
            $options = array();
        }

        return $this->factory->create($name, $options);
    }

    /**
     * @param string $name
     * @param mixed  $value
     * @param bool   $isFactory
     *
     * @return self
     */
    public function set($name, $value, $isFactory = true)
    {
        if ($value instanceof \Closure && $isFactory) {
            $this->factory->addCallback($name, $value);
        } else {
            $this->config[$name] = $value;
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->config) || $this->factory->hasCallback($name);
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function remove($name)
    {
        unset($this->config[$name]);
        $this->factory->removeCallback($name);

        return $this;
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    public function getIterator()
    {
        $iterator = new \AppendIterator();
        $iterator->append(new \ArrayIterator($this->config));
        $iterator->append($this->factory->getIterator());

        return $iterator;
    }
}
