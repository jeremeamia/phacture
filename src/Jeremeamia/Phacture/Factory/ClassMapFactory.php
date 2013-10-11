<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\FactoryDecorator\BaseDecorator;
use Jeremeamia\Phacture\FactoryInterface;

class ClassMapFactory extends BaseDecorator
{
    /**
     * @var array
     */
    protected $classMap = array();

    /**
     * @var string
     */
    protected $defaultClass;

    /**
     * @param array            $classes
     * @param FactoryInterface $innerFactory
     */
    public function __construct(array $classes = array(), FactoryInterface $innerFactory = null)
    {
        $this->innerFactory = $innerFactory ?: new ClassFactory;

        foreach ($classes as $name => $fqcn) {
            $this->addClass($name, $fqcn);
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
        $this->classMap[$name] = $fqcn;

        return $this;
    }

    /**
     * @param string $fqcn
     *
     * @return $this
     */
    public function setDefaultClass($fqcn)
    {
        $this->defaultClass = $fqcn;

        return $this;
    }

    public function doCreate($name, array $options)
    {
        return $this->innerFactory->create($this->resolveFqcn($name), $options);
    }

    public function canCreate($name)
    {
        $fqcn = isset($this->classMap[$name]) ? $this->classMap[$name] : $this->defaultClass;

        return isset($fqcn) && class_exists($fqcn);
    }
}



