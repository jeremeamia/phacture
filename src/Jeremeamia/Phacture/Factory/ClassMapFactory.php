<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\Instantiator\DefaultInstantiator;
use Jeremeamia\Phacture\Instantiator\InstantiatorInterface;
use Jeremeamia\Phacture\Resolver\ClassMapFqcnResolver;
use Jeremeamia\Phacture\Resolver\FqcnResolverInterface;

class ClassMapFactory implements AliasFactoryInterface
{
    use ClassFactoryTrait;

    /**
     * @var ClassMapFqcnResolver
     */
    protected $fqcnResolver;

    public function __construct(array $classMap = [], InstantiatorInterface $instantiator = null)
    {
        $this->setFqcnResolver(new ClassMapFqcnResolver($classMap));
        $this->setInstantiator($instantiator ?: new DefaultInstantiator);
    }

    public function setFqcnResolver(ClassMapFqcnResolver $fqcnResolver)
    {
        $this->fqcnResolver = $fqcnResolver;
    }

    public function addClass($alias, $fqcn)
    {
        $this->fqcnResolver->addClass($alias, $fqcn);

        return $this;
    }

    public function removeClass($alias)
    {
        $this->fqcnResolver->removeClass($alias);

        return $this;
    }
}



