<?php

namespace Jeremeamia\Phacture\Factory;

trait CallbackFactoryTrait
{
    use AliasFactoryTrait;

    /**
     * @var array
     */
    protected $callbackMap = [];

    /**
     * @param string   $name
     * @param callable $callback
     *
     * @return self
     */
    public function addCallback($name, callable $callback)
    {
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

    public function create($name, $options = [])
    {
        $options = $this->convertOptionsToArray($options);

        if (isset($this->callbackMap[$name])) {
            return $this->callbackMap[$name]($options);
        } else {
            throw (new FactoryException)->setName($name)->setOptions($options);
        }
    }

    public function canCreate($name)
    {
        return isset($this->callbackMap[$name]);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->callbackMap);
    }
}



