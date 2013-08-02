<?php

namespace Jeremeamia\Phacture\Resolver;

use Jeremeamia\Phacture\HandlesOptionsTrait;

class RequiredOptionsResolver implements OptionsResolverInterface
{
    use HandlesOptionsTrait;

    /**
     * @var array
     */
    protected $defaultOptions = [];

    /**
     * @var array
     */
    protected $requiredOptions = [];

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
     * @param array|\Traversable $options
     *
     * @return self
     */
    public function setRequiredOptions($options)
    {
        $this->requiredOptions = $this->convertOptionsToArray($options);

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

        if (array_diff($this->requiredOptions, array_keys($options))) {
            $keys = implode(', ', $this->requiredOptions);
            throw new \InvalidArgumentException("You must provide all of the following keys: {$keys}.");
        }

        return $options;
    }
}
