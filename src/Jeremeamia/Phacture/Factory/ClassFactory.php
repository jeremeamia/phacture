<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\Instantiator\DefaultInstantiator;
use Jeremeamia\Phacture\Instantiator\InstantiatorInterface;
use Jeremeamia\Phacture\Resolver\FqcnResolverInterface;

class ClassFactory implements AliasFactoryInterface
{
    use ClassFactoryTrait;

    public function __construct(FqcnResolverInterface $fqcnResolver, InstantiatorInterface $instantiator = null)
    {
        $this->setFqcnResolver($fqcnResolver);
        $this->setInstantiator($instantiator ?: new DefaultInstantiator);
    }
}
