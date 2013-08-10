<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\FactoryException;

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

    public function create($identifier, $options = [])
    {
        $options = $this->prepareOptions($options);

        if (isset($this->callbacks[$identifier])) {
            return $this->callbacks[$identifier]($identifier, $options);
        } else {
            throw (new FactoryException)->setContext($identifier, $options);
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



