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
     * @param string   $identifier
     * @param callable $callback
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function addCallback($identifier, $callback)
    {
        if (is_callable($callback)) {
            $this->callbacks[$identifier] = $callback;
        } else {
            throw new \InvalidArgumentException('The value provided was not a valid callback.');
        }

        return $this;
    }

    public function doCreate($identifier, array $options)
    {
        return call_user_func($this->callbacks[$identifier], $identifier, $options);
    }

    public function canCreate($identifier)
    {
        return isset($this->callbacks[$identifier]);
    }
}
