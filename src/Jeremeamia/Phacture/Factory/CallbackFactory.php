<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\FactoryInterface;

class CallbackFactory extends BaseFactory
{
    /**
     * @var array
     */
    protected $callbacks = array();
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
     * @param string   $name
     * @param callable $callback
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function addCallback($name, $callback)
    {
        if (is_callable($callback)) {
            $this->callbacks[$name] = $callback;
        } else {
            throw new \InvalidArgumentException('The value provided was not a valid callback.');
        }

        return $this;
    }

    public function doCreate($name, array $options)
    {
        return call_user_func($this->callbacks[$name], $name, $options);
    }

    public function canCreate($name)
    {
        return isset($this->callbacks[$name]);
    }
}
