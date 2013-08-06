<?php

namespace Jeremeamia\Phacture\Factory;

trait CallbackFactoryTrait
{
    use FactoryTrait;

    /**
     * @var array
     */
    protected $callbacks = [];

    /**
     * @param string   $identifier
     * @param callable $callback
     *
     * @return self
     */
    public function addCallback($identifier, callable $callback)
    {
        $this->callbacks[$identifier] = $callback;

        return $this;
    }

    /**
     * @param string $identifier
     *
     * @return self
     */
    public function removeCallback($identifier)
    {
        unset($this->callbacks[$identifier]);

        return $this;
    }

    public function create($identifier, $options = [])
    {
        $options = $this->convertOptionsToArray($options);

        if (isset($this->callbacks[$identifier])) {
            return $this->callbacks[$identifier]($options);
        } else {
            throw (new FactoryException)->setIdentifier($identifier)->setOptions($options);
        }
    }

    public function canCreate($identifier)
    {
        return isset($this->callbacks[$identifier]);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->callbacks);
    }
}



