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

    public function setDefaultClass($fqcn)
    {
        if (class_exists($this->defaultClass)) {
            $this->defaultClass = $fqcn;
        } else {
            throw new \InvalidArgumentException('{$fqcn} does not exist and cannot be assigned as default class.');
        }
    }

    public function resolveFqcn($identifier)
    {
        if (isset($this->classes[$identifier]) && class_exists($this->classes[$identifier])) {
            return $this->classes[$identifier];
        } elseif ($this->defaultClass) {
            return $this->defaultClass;
        }

        return null;
    }
}
