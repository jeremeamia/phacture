<?php

namespace Jeremeamia\Phacture\Resolver;

use Jeremeamia\Phacture\PrioritizedRecursiveArrayIterator;

class NamespaceFqcnResolver implements FqcnResolverInterface, \IteratorAggregate
{
    /**
     * @var array
     */
    private $namespaces = [];

    /**
     * @var \RecursiveIteratorIterator
     */
    private $iterator;

    public function __construct(array $namespaces = [])
    {
        foreach ($namespaces as $namespace) {
            $this->addNamespace($namespace);
        }
    }

    /**
     * @param string $namespace
     * @param int    $priority
     *
     * @return self
     */
    public function addNamespace($namespace, $priority = 0)
    {
        if (!isset($this->namespaces[$priority])) {
            $this->namespaces[$priority] = [];
        }

        $this->namespaces[$priority][] = trim($namespace, '\\');
        $this->iterator = null;

        return $this;
    }

    /**
     * @param string $namespace
     *
     * @return self
     */
    public function removeNamespace($namespace)
    {
        $namespace = trim($namespace, '\\');
        foreach ($this->namespaces as $priority => $namespaces) {
            if ($index = array_search($namespace, $namespaces)) {
                unset($this->namespaces[$priority][$index]);
                $this->iterator = null;
                break;
            }
        }

        return $this;
    }

    public function getIterator()
    {
         if (!$this->iterator) {
             $this->iterator = new \RecursiveIteratorIterator(
                 new PrioritizedRecursiveArrayIterator($this->namespaces)
             );
         }

         return $this->iterator;
    }

    public function resolveFqcn($alias)
    {
        if (is_string($alias)) {
            foreach ($this->getIterator() as $namespace) {
                $fqcn = $namespace . '\\' . $alias;
                if (class_exists($fqcn)) {
                    return $fqcn;
                }
            }
        }

        return null;
    }
}
