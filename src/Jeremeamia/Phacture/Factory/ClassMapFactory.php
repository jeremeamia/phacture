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
        $this->setFqcnResolver(new ClassMapFqcnResolver);
        $this->setInstantiator($instantiator ?: new DefaultInstantiator);

        foreach ($classMap as $alias => $fqcn) {
            $this->addClass($alias, $fqcn);
        }
    }

    public function setFqcnResolver(FqcnResolverInterface $fqcnResolver)
    {
        if (!($fqcnResolver instanceof ClassMapFqcnResolver)) {
            throw new \InvalidArgumentException('A ClassMapFactory only supports the ClassMapFqcnResolver.');
        }

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



