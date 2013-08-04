<?php

namespace Jeremeamia\Phacture\Factory;

class CallbackFactory implements AliasFactoryInterface, \IteratorAggregate
{
    use CallbackFactoryTrait;

    /**
     * @param array $callbackMap
     */
    public function __construct(array $callbackMap = [])
    {
        foreach ($callbackMap as $name => $callback) {
            $this->addCallback($name, $callback);
        }
    }
}
