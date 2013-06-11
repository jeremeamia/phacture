<?php

namespace Jeremeamia\Phacture\Resolver;

use Jeremeamia\Phacture\OptionsHelper;

class RequiredOptionsResolver implements OptionsResolverInterface
{
    /**
     * @var array
     */
    protected $defaultOptions = array();

    /**
     * @var array
     */
    protected $requiredOptions = array();

    /**
     * @param array|\Traversable $options
     *
     * @return self
     */
    public function setDefaultOptions($options)
    {
        $this->defaultOptions = OptionsHelper::arrayify($options);

        return $this;
    }

    /**
     * @param array|\Traversable $options
     *
     * @return self
     */
    public function setRequiredOptions($options)
    {
        $this->requiredOptions = OptionsHelper::arrayify($options);

        return $this;
    }

    /**
     * @param array|\Traversable $options
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public function resolveOptions($options)
    {
        $options = array_replace($this->defaultOptions, OptionsHelper::arrayify($options));

        if (array_diff($this->requiredOptions, array_keys($options))) {
            $keys = implode(', ', $this->requiredOptions);
            throw new \InvalidArgumentException("You must provide all of the following keys: {$keys}.");
        }

        return $options;
    }
}
