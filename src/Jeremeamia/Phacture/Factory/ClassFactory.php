<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\OptionsOnlyFactoryInterface;

/**
 *
 */
class ClassFactory extends BaseFactory
{
    /**
     * @var string Factory method to use if it exists on the class
     */
    protected $factoryMethod;

    /**
     * @var bool Option to execute a factory object if one is instantiated by this factory
     */
    protected $executeFactories;

    public function __construct($factoryMethod = 'factory', $executeFactories = true)
    {
        $this->factoryMethod = $factoryMethod;
        $this->executeFactories = (bool) $executeFactories;
    }

    public function canCreate($name)
    {
        return class_exists($name);
    }

    protected function doCreate($name, array $options)
    {
        // We will treat the name as if it is a fully qualified class name (FQCN)
        $fqcn = $name;

        // Retrieve an instance of the object
        if ($this->factoryMethod && method_exists($fqcn, $this->factoryMethod)) {
            $object = call_user_func("{$fqcn}::{$this->factoryMethod}", $options);
        } else {
            $object = new $fqcn;
        }

        // If the object is a factory, execute it
        if ($this->executeFactories && $object instanceof OptionsOnlyFactoryInterface) {
            $object = $object->create($options);
        }

        return $object;
    }
}
