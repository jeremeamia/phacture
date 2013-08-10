<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\PrioritizedRecursiveArrayIterator;

trait NamespaceFactoryTrait
{
    use ClassFactoryTrait;

    /**
     * @var array
     */
    private $namespaces = [];

    private $prefix = '';

    private $suffix = '';

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

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;

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

    public function resolveFqcn($identifier)
    {
        if (is_string($identifier)) {
            $identifier = "{$this->prefix}{$identifier}{$this->suffix}";
            foreach ($this->getIterator() as $namespace) {
                $fqcn = "{$namespace}\\{$identifier}";
                if (class_exists($fqcn)) {
                    return $fqcn;
                }
            }
        }

        return null;
    }
}
