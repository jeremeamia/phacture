<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\FactoryDecorator\BaseDecorator;
use Jeremeamia\Phacture\FactoryInterface;

class NamespaceFactory extends BaseDecorator
{
    /**
     * @var array
     */
    protected $namespaces = array();

    /**
     * @var string
     */
    protected $prefix = '';

    /**
     * @var string
     */
    protected $suffix = '';

    /**
     * @var array
     */
    protected $resolvedNames = array();

    /**
     * @param array            $namespaces
     * @param FactoryInterface $innerFactory
     */
    public function __construct($namespaces = array(), FactoryInterface $innerFactory = null)
    {
        $this->innerFactory = $innerFactory ?: new ClassFactory;

        $namespaces = (array) $namespaces;
        foreach ($namespaces as $namespace) {
            $this->addNamespace($namespace);
        }
    }

    /**
     * @param string $prefix
     *
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = (string) $prefix;
        $this->resolvedNames = array();

        return $this;
    }

    /**
     * @param string $suffix
     *
     * @return $this
     */
    public function setSuffix($suffix)
    {
        $this->suffix = (string) $suffix;
        $this->resolvedNames = array();

        return $this;
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
        $this->resolvedNames = array();

        return $this;
    }

    public function canCreate($name)
    {
        if (!isset($this->resolvedNames[$name])) {
            // Sort the namespaces to be in proper priority order
            krsort($this->namespaces);

            // Default resolved name to a not-found state
            $this->resolvedNames[$name] = false;

            // Iterate through the namespaces and look for one containing the class name
            foreach ($this->namespaces as $namespaces) {
                foreach ($namespaces as $namespace) {
                    $fqcn = "{$namespace}\\{$this->prefix}{$name}{$this->suffix}";
                    if (class_exists($fqcn)) {
                        $this->resolvedNames[$name] = $fqcn;
                        break(2);
                    }
                }
            }
        }

        return (bool) $this->resolvedNames[$name];
    }

    protected function doCreate($name, array $options)
    {
        return $this->innerFactory->create($this->resolvedNames[$name], $options);
    }
}
