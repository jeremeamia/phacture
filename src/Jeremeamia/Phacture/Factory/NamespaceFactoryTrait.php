<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\PrioritizedRecursiveArrayIterator;

trait NamespaceFactoryTrait
{
    use ClassFactoryTrait;

    /**
     * @var array
     */
    protected $namespaces = [];

    /**
     * @var \RecursiveIteratorIterator
     */
    protected $iterator;

    /**
     * @param array $namespaces
     */
    public function __construct(array $namespaces = [])
    {
        foreach ($namespaces as $key => $value) {
            if (is_string($key) && is_int($value)) {
                $this->addNamespace($key, $value);
            } else {
                $this->addNamespace($value);
            }
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

    public function getFullyQualifiedClassName($name, array $options)
    {
        foreach ($this->getIterator() as $namespace) {
            $fqcn = $namespace . '\\' . $name;
            if (class_exists($fqcn)) {
                return $fqcn;
            }
        }

        return null;
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
}
