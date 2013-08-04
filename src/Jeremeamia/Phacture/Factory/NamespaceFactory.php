<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\Instantiator\DefaultInstantiator;
use Jeremeamia\Phacture\Instantiator\InstantiatorInterface;
use Jeremeamia\Phacture\Resolver\NamespaceFqcnResolver;
use Jeremeamia\Phacture\Resolver\FqcnResolverInterface;

class NamespaceFactory implements AliasFactoryInterface
{
    use ClassFactoryTrait;

    /**
     * @var NamespaceFqcnResolver
     */
    protected $fqcnResolver;

    public function __construct(array $namespaces = [], InstantiatorInterface $instantiator = null)
    {
        $this->setFqcnResolver(new NamespaceFqcnResolver);
        $this->setInstantiator($instantiator ?: new DefaultInstantiator);

        foreach ($namespaces as $namespace) {
            $this->addNamespace($namespace);
        }
    }

    public function setFqcnResolver(NamespaceFqcnResolver $fqcnResolver)
    {
        $this->fqcnResolver = $fqcnResolver;
    }

    public function addNamespace($namespace)
    {
        $this->fqcnResolver->addNamespace($namespace);

        return $this;
    }

    public function removeNamespace($namespace)
    {
        $this->fqcnResolver->removeNamespace($namespace);

        return $this;
    }
}
