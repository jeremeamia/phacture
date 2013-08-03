<?php

namespace Jeremeamia\Phacture\Factory;

class ClassMapFactory implements FactoryInterface, \IteratorAggregate
{
    use ClassMapFactoryTrait;

    /**
     * @param array $classMap
     */
    public function __construct(array $classMap = array())
    {
        foreach ($classMap as $name => $fcqn) {
            $this->addClass($name, $fcqn);
        }
    }
}



