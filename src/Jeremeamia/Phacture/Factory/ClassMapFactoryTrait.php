<?php

namespace Jeremeamia\Phacture\Factory;

trait ClassMapFactoryTrait
{
    use ClassFactoryTrait;

    /**
     * @var array
     */
    private $classes = [];

    /**
     * @var string
     */
    private $defaultClass;

    /**
     * @param string $identifier
     * @param string $fqcn
     *
     * @return self
     */
    public function addClass($identifier, $fqcn)
    {
        $this->classes[$identifier] = $fqcn;

        return $this;
    }

    /**
     * @param string $identifier
     *
     * @return self
     */
    public function removeClass($identifier)
    {
        unset($this->classes[$identifier]);

        return $this;
    }

    public function setDefaultClass($fqcn)
    {
        $this->defaultClass = $fqcn;
    }

    public function resolveFqcn($identifier)
    {
        if (is_string($identifier) && isset($this->classes[$identifier]) && class_exists($this->classes[$identifier])) {
            return $this->classes[$identifier];
        } elseif ($this->defaultClass && class_exists($this->defaultClass)) {
            return $this->defaultClass;
        }

        return null;
    }
}
