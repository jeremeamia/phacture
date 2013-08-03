<?php

namespace Jeremeamia\Phacture\Factory;

class NamespaceFactory implements FactoryInterface, \IteratorAggregate
{
    use NamespaceFactoryTrait;

    /**
     * @param array $namespaces
     */
    public function __construct(array $namespaces = [])
    {
        foreach ($namespaces as $key => $value) {
            if (is_string($key) && is_int($value)) {
                $this->addNamespace($key, $value);
            } else {
                $this->addNamespace($value);
            }
        }
    }
}
