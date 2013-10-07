<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Factory\FactoryInterface;
use Jeremeamia\Phacture\HandlesOptionsTrait;

class FlyweightFactoryDecorator extends AbstractFactoryDecorator
{
    const OPTION_USE_NEW = 'use_new';

    /**
     * @var array
     */
    protected $itemCache = [];

    /**
     * @var callable
     */
    protected $keyCalculator;

    public function __construct(FactoryInterface $factory, callable $keyCalculator = null)
    {
        $this->innerFactory = $factory;
        $this->keyCalculator = $keyCalculator;
    }

    /**
     * {@inheritdoc}
     */
    public function create($identifier, $options = [])
    {
        $options = $this->prepareOptions($options);
        $key = $this->calculateKey($identifier, $options);

        if (isset($options[self::OPTION_USE_NEW]) && $options[self::OPTION_USE_NEW]) {
            unset($this->itemCache[$key], $options[self::OPTION_USE_NEW]);
        }

        if (!isset($this->itemCache[$key])) {
            $this->itemCache[$key] = $this->innerFactory->create($identifier, $options);
        }

        return $this->itemCache[$key];
    }

    /**
     * Clears the cache of items that the flyweight factory has stored
     *
     * @return self
     */
    public function clearCache()
    {
        $this->itemCache = [];

        return $this;
    }

    public function setKeyCalculator(callable $keyCalculator)
    {
        $this->keyCalculator = $keyCalculator;

        return $this;
    }

    /**
     * Determines the key used to cache the objects.
     *
     * @param string $identifier
     * @param array  $options
     *
     * @return string
     */
    private function calculateKey($identifier, array $options)
    {
        $calculate = $this->keyCalculator;

        return $calculate ? $calculate($identifier, $options) : $identifier;
    }
}
