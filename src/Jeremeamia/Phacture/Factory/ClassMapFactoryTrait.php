<?php

namespace Jeremeamia\Phacture\Factory;

trait ClassMapFactoryTrait
{
    use ClassFactoryTrait;

    /**
     * @var array
     */
    protected $classMap = [];

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

    public function getFullyQualifiedClassName($name, array $options = array())
    {
        if (isset($this->classMap[$name]) && class_exists($this->classMap[$name])) {
            return $this->classMap[$name];
        }

        return null;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->classMap);
    }
}



