<?php

namespace Jeremeamia\Phacture\Factory;

class NamespaceFactory implements FactoryInterface, \IteratorAggregate
{
    use NamespaceFactoryTrait;

    public function __construct(array $namespaces = [])
    {
        foreach ($namespaces as $namespace) {
            $this->addNamespace($namespace);
        }
    }
}
