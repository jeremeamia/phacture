<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\FactoryInterface;

/**
 *
 */
class ClassFactory extends BaseFactory
{
    public function __construct($factoryMethod = 'factory')
    {
        $this->factoryMethod = $factoryMethod;
    }

    public function canCreate($identifier)
    {
        return class_exists($identifier);
    }

    protected function doCreate($identifier, array $options)
    {
        // We will treat the identifier as if it is a fully qualified class name (FQCN)
        $fqcn = $identifier;

        if (method_exists($fqcn, $this->factoryMethod)) {
            return call_user_func(array($fqcn, $this->factoryMethod), $options);
        } else {
            return new $fqcn;
        }
    }
}
