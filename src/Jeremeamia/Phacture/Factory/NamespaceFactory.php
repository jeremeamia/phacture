<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\PrioritizedRecursiveArrayIterator;

class NamespaceFactory extends AbstractClassFactory implements \IteratorAggregate
{
    /**
     * @var array
     */
    protected $namespaces = array();

    /**
     * @var \RecursiveIteratorIterator
     */
    protected $iterator;

    /**
     * @param array $namespaces
     */
    public function __construct(array $namespaces = array())
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
            $this->namespaces[$priority] = array();
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

    /**
     * @return \Iterator
     */
    public function getIterator()
    {
         if (!$this->iterator) {
             $this->iterator = new \RecursiveIteratorIterator(new PrioritizedRecursiveArrayIterator($this->namespaces));
         }

         return $this->iterator;
    }

    public function getFullyQualifiedClassName($name, array $options = array())
    {
        foreach ($this->getIterator() as $namespace) {
            $fqcn = $namespace . '\\' . $name;
            if (class_exists($fqcn)) {
                return $fqcn;
            }
        }

        return null;
    }
}
