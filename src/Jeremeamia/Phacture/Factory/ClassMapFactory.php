<?php

namespace Jeremeamia\Phacture\Factory;

class ClassMapFactory implements FactoryInterface
{
    use ClassMapFactoryTrait;

    public function __construct(array $classes = [])
    {
        foreach ($classes as $identifier => $fqcn) {
            $this->addClass($identifier, $fqcn);
        }
    }
}



