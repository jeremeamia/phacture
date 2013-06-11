<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\OptionsHelper;

class CallbackFactory implements FactoryInterface, \IteratorAggregate
{
    /**
     * @var array
     */
    protected $callbackMap = array();

    /**
     * @param array $callbackMap
     */
    public function __construct(array $callbackMap = array())
    {
        foreach ($callbackMap as $name => $callback) {
            $this->addCallback($name, $callback);
        }
    }

    /**
     * @param string $name
     * @param mixed  $callback
     *
     * @return self
     * @throws \InvalidArgumentException If the callback is not callable
     */
    public function addCallback($name, $callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('You must provide a valid callback.');
        }

        $this->callbackMap[$name] = $callback;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasCallback($name)
    {
        return isset($this->callbackMap[$name]);
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function removeCallback($name)
    {
        unset($this->callbackMap[$name]);

        return $this;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->callbackMap);
    }

    public function create($name, $options = array())
    {
        $options = OptionsHelper::arrayify($options);
        if (isset($this->callbackMap[$name])) {
            $callback = $this->callbackMap[$name];
            return $options ? call_user_func_array($callback, $options) : call_user_func($callback);
        } else {
            throw new FactoryException("There is no callback to call associated with \"{$name}\".");
        }
    }
}



