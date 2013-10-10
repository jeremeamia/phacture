<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\FactoryInterface;

class RequiredOptionsDecorator extends BaseDecorator
{
    /**
     * @var array
     */
    protected $requiredKeys = array();

    /**
     * @var array
     */
    protected $defaultOptions = array();

    /**
     * @param FactoryInterface $innerFactory
     * @param array            $requiredKeys
     * @param array            $defaultOptions
     */
    public function __construct(
        FactoryInterface $innerFactory,
        array $requiredKeys = array(),
        array $defaultOptions = array()
    ) {
        $this->innerFactory = $innerFactory;
        $this->setRequiredKeys($requiredKeys);
        $this->setDefaultOptions($defaultOptions);
    }

    /**
     * @param array $keys
     *
     * @return $this
     */
    public function setRequiredKeys(array $keys)
    {
        $this->requiredKeys = $keys;

        return $this;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function setDefaultOptions(array $options)
    {
        $this->defaultOptions = $options;

        return $this;
    }

    public function doCreate($identifier, array $options)
    {
        $options = $options + $this->defaultOptions;

        if (array_diff($this->requiredKeys, array_keys($options))) {
            $keys = implode(', ', $this->requiredKeys);
            throw new \RuntimeException("All of the following options are required: {$keys}.");
        }

        return $this->innerFactory->create($identifier, $options);
    }
}
