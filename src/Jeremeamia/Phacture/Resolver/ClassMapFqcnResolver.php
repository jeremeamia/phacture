<?php

namespace Jeremeamia\Phacture\Resolver;

class ClassMapFqcnResolver implements FqcnResolverInterface
{
    /**
     * @var array
     */
    private $classes = [];

    /**
     * @param string $alias
     * @param string $fqcn
     *
     * @throws \InvalidArgumentException
     * @return self
     */
    public function addClass($alias, $fqcn)
    {
        $fqcn = trim($fqcn, '\\');
        if (!class_exists($fqcn)) {
            throw new \InvalidArgumentException("The {$fqcn} class does not exist.");
        }

        $this->classes[$alias] = $fqcn;

        return $this;
    }

    /**
     * @param string $alias
     *
     * @return self
     */
    public function removeClass($alias)
    {
        unset($this->classes[$alias]);

        return $this;
    }

    public function resolveFqcn($alias)
    {
        if (is_string($alias) && isset($this->classes[$alias]) && class_exists($this->classes[$alias])) {
            return $this->classes[$alias];
        }

        return null;
    }
}
