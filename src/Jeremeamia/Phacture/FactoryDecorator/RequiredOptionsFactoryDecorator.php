<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Resolver\EnforcesRequiredOptionsTrait;
use Jeremeamia\Phacture\Factory\FactoryInterface;

class RequiredOptionsFactoryDecorator extends AbstractFactoryDecorator
{
    use EnforcesRequiredOptionsTrait;

    /**
     * @param FactoryInterface $factory
     * @param array            $requiredKeys
     * @param mixed            $defaultOptions
     */
    public function __construct(FactoryInterface $factory, array $requiredKeys = [], $defaultOptions = [])
    {
        $this->innerFactory = $factory;
        $this->setRequiredKeys($requiredKeys);
        $this->setDefaultOptions($defaultOptions);
    }

    public function create($identifier, $options = [])
    {
        return $this->innerFactory->create($identifier, $this->resolveOptions($options));
    }
}
