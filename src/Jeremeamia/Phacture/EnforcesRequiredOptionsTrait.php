<?php

namespace Jeremeamia\Phacture\Resolver;

use Jeremeamia\Phacture\HandlesOptionsTrait;

trait EnforcesRequiredOptionsTrait
{
    use HandlesOptionsTrait;

    /**
     * @var array
     */
    protected $defaultOptions = [];

    /**
     * @var array
     */
    protected $requiredKeys = [];

    /**
     * @param array $keys
     *
     * @return self
     */
    public function setRequiredKeys(array $keys)
    {
        $this->requiredKeys = $keys;

        return $this;
    }

    /**
     * @param mixed $options
     *
     * @return self
     */
    public function setDefaultOptions($options)
    {
        $this->defaultOptions = $this->convertOptionsToArray($options);

        return $this;
    }

    /**
     * @param mixed $options
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public function resolveOptions($options)
    {
        $options = array_replace($this->defaultOptions, $this->convertOptionsToArray($options));

        if (array_diff($this->requiredKeys, array_keys($options))) {
            $keys = implode(', ', $this->requiredKeys);
            throw new \InvalidArgumentException("You must provide all of the following keys: {$keys}.");
        }

        return $options;
    }
}
