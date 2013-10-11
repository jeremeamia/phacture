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
     * @var OptionsOnlyFactoryInterface
     */
    protected $defaultFactory;

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

        foreach ($factories as $name => $factory) {
            $this->addFactory($name, $factory);
        }
    }

    /**
     * @param string                             $name
     * @param OptionsOnlyFactoryInterface|string $factory
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function addFactory($name, $factory)
    {
        $factoryInterface = 'Jeremeamia\Phacture\OptionsOnlyFactoryInterface';
        if (is_subclass_of($factory, $factoryInterface)) {
            $this->factoryMap[$name] = $factory;
        } else {
            throw new \InvalidArgumentException("The factory specified does not implement the {$factoryInterface}.");
        }

        return $this;
    }

    /**
     * @param OptionsOnlyFactoryInterface $factory
     *
     * @return $this
     */
    public function setDefaultFactory(OptionsOnlyFactoryInterface $factory)
    {
        $this->defaultFactory = $factory;

        return $this;
    }

    public function doCreate($name, array $options)
    {
        $factory = isset($this->factoryMap[$name]) ? $this->factoryMap[$name] : $this->defaultFactory;

        if (!is_object($factory)) {
            $factory = new $factory;
        }

        return $factory->create($options);
    }

    public function canCreate($name)
    {
        return $this->defaultFactory || isset($this->factories[$name]);
    }
}



