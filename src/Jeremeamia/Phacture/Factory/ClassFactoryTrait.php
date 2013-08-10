<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\FactoryException;

/**
 * Trait for factories that must determine the FQCN from the provided identifier
 */
trait ClassFactoryTrait
{
    use FactoryTrait;

    public function create($identifier, $options = [])
    {
        $options = $this->prepareOptions($options);
        $fqcn = $this->resolveFqcn($identifier);

        try {
            return $this->instantiateClass($fqcn, $options);
        } catch (FactoryException $e) {
            throw $e->setContext($identifier, $options);
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
        $factoryMethod = [$fqcn, 'factory'];
        if (is_callable($factoryMethod)) {
            return $factoryMethod($options);
        } else {
            return new $fqcn;
        }
    }

    /**
     * @param $identifier
     *
     * @return bool
     */
    abstract protected function resolveFqcn($identifier);
}
