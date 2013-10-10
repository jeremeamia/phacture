<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\FactoryException;
use Jeremeamia\Phacture\OptionsOnlyFactoryInterface;

class FactoryMapFactory extends BaseFactory
{
    /**
     * @var array
     */
    protected $factoryMap = array();

    /**
     * @param array $factories
     *
     * @throws \RuntimeException
     */
    public function __construct(array $factories = array())
    {
        if (PHP_VERSION_ID < 50307) {
            throw new \RuntimeException('PHP 5.3.7 or higher is required to use the FactoryMapFactory.');
        }

        foreach ($factories as $identifier => $factory) {
            $this->addFactory($identifier, $factory);
        }
    }

    /**
     * @param string                             $identifier
     * @param OptionsOnlyFactoryInterface|string $factory
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function addFactory($identifier, $factory)
    {
        $factoryInterface = 'Jeremeamia\Phacture\OptionsOnlyFactoryInterface';
        if (is_subclass_of($factory, $factoryInterface)) {
            $this->factoryMap[$identifier] = $factory;
        } else {
            throw new \InvalidArgumentException("The factory specified does not implement the {$factoryInterface}.");
        }

        return $this;
    }

    public function doCreate($identifier, array $options)
    {
        $factory = $this->factoryMap[$identifier];
        if (!is_object($factory)) {
            $factory = new $factory;
        }

        return $factory->create($options);
    }

    public function canCreate($identifier)
    {
        return isset($this->factories[$identifier]);
    }
}



