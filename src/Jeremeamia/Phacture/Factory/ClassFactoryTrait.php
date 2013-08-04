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
    }

    public function setInstantiator(InstantiatorInterface $instantiator)
    {
        $this->instantiator = $instantiator;
    }

    public function create($name, $options = [])
    {
        $options = $this->convertOptionsToArray($options);

        if ($fqcn = $this->fqcnResolver->resolveFqcn($name)) {
            return $this->instantiator->instantiateClass($fqcn, $options);
        } else {
            throw (new FactoryException)->setName($name)->setOptions($options);
        }
    }

    public function canCreate($name)
    {
        return (bool) $this->fqcnResolver->resolveFqcn($name);
    }
}
