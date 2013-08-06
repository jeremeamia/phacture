<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\Instantiator\InstantiatorInterface;
use Jeremeamia\Phacture\Resolver\FqcnResolverInterface;

/**
 * Trait for factories that must determine the FQCN from the provided name
 */
trait ClassFactoryTrait
{
    use FactoryTrait;

    public function create($identifier, $options = [])
    {
        $options = $this->convertOptionsToArray($options);
        $fqcn = $this->resolveFqcn($identifier);

        try {
            return $this->instantiateClass($fqcn, $options);
        } catch (FactoryException $e) {
            throw $e->setIdentifier($identifier)->setFqcn($fqcn)->setOptions($options);
        }
    }

    public function canCreate($identifier)
    {
        return (bool) $this->resolveFqcn($identifier);
    }

    /**
     * @param string $fqcn
     * @param array  $options
     *
     * @return mixed
     */
    protected function instantiateClass($fqcn, array $options)
    {
        $factoryMethod = array($fqcn, 'factory');
        if (is_callable($factoryMethod)) {
            return $factoryMethod($options);
        } else {
            return $this->instantiateClassWithConstructor($fqcn, $options);
        }
    }

    protected function instantiateClassWithConstructor($fqcn, array $args)
    {
        $count = count($args);

        if ($count === 0) {
            return new $fqcn;
        } elseif ($count === 1) {
            return new $fqcn($args[0]);
        } elseif ($count === 2) {
            return new $fqcn($args[0], $args[1]);
        } elseif ($count === 3) {
            return new $fqcn($args[0], $args[1], $args[2]);
        } else {
            $class = new \ReflectionClass($fqcn);

            return $class->newInstanceArgs($args);
        }
    }

    /**
     * @param $identifier
     *
     * @return bool
     */
    abstract protected function resolveFqcn($identifier);
}
