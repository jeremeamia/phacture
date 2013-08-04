<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\Instantiator\InstantiatorInterface;
use Jeremeamia\Phacture\Resolver\FqcnResolverInterface;

/**
 * Trait for factories that must determine the FQCN from the provided name
 */
trait ClassFactoryTrait
{
    use AliasFactoryTrait;

    /**
     * @var FqcnResolverInterface
     */
    protected $fqcnResolver;

    /**
     * @var InstantiatorInterface
     */
    protected $instantiator;

    public function setFqcnResolver(FqcnResolverInterface $fqcnResolver)
    {
        $this->fqcnResolver = $fqcnResolver;

        return $this;
    }

    public function setInstantiator(InstantiatorInterface $instantiator)
    {
        $this->instantiator = $instantiator;

        return $this;
    }

    public function create($name, $options = [])
    {
        $options = $this->convertOptionsToArray($options);
        $fqcn = $this->fqcnResolver->resolveFqcn($name);

        try {
            return $this->instantiator->instantiateClass($fqcn, $options);
        } catch (FactoryException $e) {
            throw $e->setName($name)
                ->setFqcn($fqcn)
                ->setOptions($options);
        }
    }

    public function canCreate($name)
    {
        return (bool) $this->fqcnResolver->resolveFqcn($name);
    }
}
