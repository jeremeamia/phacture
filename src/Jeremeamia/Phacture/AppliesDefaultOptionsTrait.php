<?php

namespace Jeremeamia\Phacture;

use Jeremeamia\Phacture\HandlesOptionsTrait;

trait AppliesDefaultOptionsTrait
{
    use HandlesOptionsTrait;

    /**
     * @var array
     */
    protected $defaultOptions = [];

    /**
     * @param mixed $options
     *
     * @return self
     */
    public function setDefaultOptions($options)
    {
        $this->defaultOptions = $this->prepareOptions($options);

        return $this;
    }

    /**
     * @param mixed $options
     *
     * @return array
     */
    public function applyDefaultOptions($options)
    {
        return $this->prepareoptions($options) + $this->defaultOptions;
    }
}
