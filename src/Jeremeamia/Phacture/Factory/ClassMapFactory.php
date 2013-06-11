<?php

namespace Jeremeamia\Phacture\Factory;

class ClassMapFactory extends AbstractClassFactory implements \IteratorAggregate
{
    /**
     * @var array
     */
    protected $classMap = array();

    /**
     * @param array $classMap
     */
    public function __construct(array $classMap = array())
    {
        foreach ($classMap as $name => $fcqn) {
            $this->addClass($name, $fcqn);
        }
    }

    /**
     * @param string $name
     * @param string $fqcn
     *
     * @return self
     */
    public function addClass($name, $fqcn)
    {
        $this->classMap[$name] = trim($fqcn, '\\');

        return $this;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function removeClass($name)
    {
        unset($this->classMap[$name]);

        return $this;
    }

    /**
     * @return array
     */
    public function getClassMap()
    {
        return $this->classMap;
    }

    /**
     * @return array
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->classMap);
    }

    /**
     * {@inheritdoc}
     */
    public function getFullyQualifiedClassName($name)
    {
        if (isset($this->classMap[$name]) && class_exists($this->classMap[$name])) {
            return $this->classMap[$name];
        }

        return null;
    }
}



