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
     * @var \Closure
     */
    protected $mapFunction;

    /**
     * @var array
     */
    protected $resolvedIdentifiers = array();

    /**
     * @param array            $classes
     * @param FactoryInterface $innerFactory
     */
    public function __construct($classes = array(), FactoryInterface $innerFactory = null)
    {
        $this->innerFactory = $innerFactory ?: new ClassFactory;

        if (is_array($classes)) {
            foreach ($classes as $identifier => $fqcn) {
                $this->addClass($identifier, $fqcn);
            }
        } elseif ($classes instanceof \Closure) {
            $this->setMapFunction($classes);
        } else {
            throw new \InvalidArgumentException('The ClassMapFactory expects either a class map array or function.');
        }
    }

    /**
     * @param string $identifier
     * @param string $fqcn
     *
     * @return self
     */
    public function addClass($identifier, $fqcn)
    {
        $this->classMap[$identifier] = $fqcn;
        $this->resolvedIdentifiers = array();

        return $this;
    }

    /**
     * @param \Closure $mapFunction
     *
     * @return $this
     */
    public function setMapFunction(\Closure $mapFunction)
    {
        $this->mapFunction = $mapFunction;
        $this->resolvedIdentifiers = array();

        return $this;
    }

    public function doCreate($identifier, array $options)
    {
        return $this->innerFactory->create($this->resolveFqcn($identifier), $options);
    }

    public function canCreate($identifier)
    {
        return (bool) $this->resolveFqcn($identifier);
    }

    protected function resolveFqcn($identifier)
    {
        if (!isset($this->resolvedIdentifiers[$identifier])) {
            // Determine the FQCN
            if (isset($this->classMap[$identifier])) {
                $fqcn = $this->classMap[$identifier];
            } elseif ($this->mapFunction) {
                $fqcn = call_user_func($this->mapFunction, $identifier);
            } else {
                $fqcn = null;
            }

            // Determine if the FQCN exists
            if ($fqcn && class_exists($fqcn)) {
                $this->resolvedIdentifiers[$identifier] = $fqcn;
            } else {
                $this->resolvedIdentifiers[$identifier] = false;
            }
        }

        return $this->resolvedIdentifiers[$identifier];
    }
}



