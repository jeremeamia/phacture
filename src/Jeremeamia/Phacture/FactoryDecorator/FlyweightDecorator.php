<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Factory\ClassFactory;
use Jeremeamia\Phacture\FactoryInterface;

class FlyweightDecorator extends BaseDecorator
{
    const OPTION_USE_NEW = 'use_new';

    /**
     * @var array
     */
    protected $itemCache = array();

    /**
     * @var \Closure
     */
    protected $keyCalculator;

    /**
     * @param FactoryInterface $innerFactory
     * @param callable         $keyCalculator
     */
    public function __construct(FactoryInterface $innerFactory = null, \Closure $keyCalculator = null)
    {
        $this->innerFactory = $innerFactory ?: new ClassFactory;
        $this->keyCalculator = $keyCalculator;
    }

    public function doCreate($identifier, array $options)
    {
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
        $this->itemCache = array();

        return $this;
    }

    /**
     * @param callable $keyCalculator
     *
     * @return $this
     */
    public function setKeyCalculator(\Closure $keyCalculator)
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
    protected function calculateKey($identifier, array $options)
    {
        return $this->keyCalculator ? call_user_func($this->keyCalculator, $identifier, $options) : $identifier;
    }
}
