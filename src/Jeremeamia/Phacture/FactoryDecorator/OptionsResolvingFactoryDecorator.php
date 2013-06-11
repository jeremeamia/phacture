<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Resolver\OptionsResolverInterface;
use Jeremeamia\Phacture\Factory\FactoryInterface;

class OptionsResolvingFactoryDecorator extends AbstractFactoryDecorator
{
    /**
     * @var OptionsResolverInterface
     */
    protected $optionsResolver;

    /**
     * @param FactoryInterface         $factory
     * @param OptionsResolverInterface $optionsResolver
     */
    public function __construct(FactoryInterface $factory, OptionsResolverInterface $optionsResolver)
    {
        $this->innerFactory = $factory;
        $this->optionsResolver = $optionsResolver;
    }

    /**
     * {@inheritdoc}
     */
    public function create($name, $options = array())
    {
        return $this->innerFactory->create($name, $this->optionsResolver->resolveOptions($options));
    }

    /**
     * @return OptionsResolverInterface
     */
    public function getOptionsResolver()
    {
        return $this->optionsResolver;
    }
}
