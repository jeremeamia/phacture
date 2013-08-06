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

    public function resolveFqcn($identifier)
    {
        if (is_string($identifier) && isset($this->classes[$identifier]) && class_exists($this->classes[$identifier])) {
            return $this->classes[$identifier];
        }

        return null;
    }
}
