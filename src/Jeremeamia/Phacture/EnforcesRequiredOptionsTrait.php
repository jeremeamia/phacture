<?php

namespace Jeremeamia\Phacture;

trait EnforcesRequiredOptionsTrait
{
    use HandlesOptionsTrait;

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
     * @return array
     * @throws \RuntimeException
     */
    public function enforceRequiredOptions($options)
    {
        $options = $this->prepareOptions($options);

        if (array_diff($this->requiredKeys, array_keys($options))) {
            $requiredKeys = $this->requiredKeys;
            $lastKey = array_pop($requiredKeys);
            $keys = implode(', ', $requiredKeys) . ', and ' . $lastKey;
            throw new \RuntimeException("All of the following options are required: {$keys}.");
        }

        return $options;
    }
}
