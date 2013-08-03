<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\HandlesOptionsTrait;
use Jeremeamia\Phacture\OptionsHelper;

class FlyweightFactoryDecorator extends AbstractFactoryDecorator
{
    use HandlesOptionsTrait;

    const OPTION_USE_NEW = 'use_new';

    /**
     * @var array
     */
    protected $itemCache = [];

    /**
     * {@inheritdoc}
     */
    public function create($name = null, $options = [])
    {
        $options = $this->convertOptionsToArray($options);
        $key = $this->calculateKey($name, $options);

        if (isset($options[self::OPTION_USE_NEW]) && $options[self::OPTION_USE_NEW]) {
            unset($this->itemCache[$key], $options[self::OPTION_USE_NEW]);
        }

        if (!isset($this->itemCache[$key])) {
            $this->itemCache[$key] = $this->innerFactory->create($name, $options);
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

    /**
     * Determines the key used to cache the objects. This should be overridden if more complex logic is required
     *
     * @param string $name
     * @param array  $options
     *
     * @return string
     */
    protected function calculateKey($name, array $options)
    {
        return $name;
    }
}
