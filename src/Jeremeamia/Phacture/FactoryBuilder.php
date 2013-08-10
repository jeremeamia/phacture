<?php

namespace Jeremeamia\Phacture;

use Jeremeamia\Phacture\BuilderInterface;
use Jeremeamia\Phacture\Factory\CallbackFactory;
use Jeremeamia\Phacture\Factory\ClassMapFactory;
use Jeremeamia\Phacture\Factory\CompositeFactory;
use Jeremeamia\Phacture\Factory\FactoryInterface;
use Jeremeamia\Phacture\Factory\FactoryMapFactory;
use Jeremeamia\Phacture\Factory\NamespaceFactory;
use Jeremeamia\Phacture\FactoryDecorator\AliasFactoryDecorator;
use Jeremeamia\Phacture\FactoryDecorator\FlyweightFactoryDecorator;
use Jeremeamia\Phacture\FactoryDecorator\IdentifierCallbackFactoryDecorator;
use Jeremeamia\Phacture\FactoryDecorator\InflectionFactoryDecorator;
use Jeremeamia\Phacture\FactoryDecorator\InitializerFactoryDecorator;
use Jeremeamia\Phacture\FactoryDecorator\RequiredOptionsFactoryDecorator;

class FactoryBuilder implements BuilderInterface
{
    private $factories = [];
    private $callbacks = [];
    private $classes = [];
    private $namespaces = [];
    private $aliases = [];
    private $initializers = [];
    private $requiredKeys = [];
    private $defaultOptions = [];
    private $customFactories = [];
    private $flyweightCaching;
    private $identifierInflection;
    private $identifierCallback;

    public function addClassMap(array $classes)
    {
        $this->classes = $classes + $this->classes;

        return $this;
    }

    public function addFactoryMap(array $factories)
    {
        $this->factories = $factories + $this->factories;

        return $this;
    }

    public function addClass($identifier, $fqcn)
    {
        $this->classes[$identifier] = $fqcn;

        return $this;
    }

    public function addFactory($identifier, $factory)
    {
        $this->factories[$identifier] = $factory;

        return $this;
    }

    public function addCallback($identifier, callable $callback)
    {
        $this->callbacks[$identifier] = $callback;

        return $this;
    }

    public function addNamespace($namespace)
    {
        $this->namespaces[] = $namespace;

        return $this;
    }

    public function addCustomFactory(FactoryInterface $factory, $priority = 0)
    {
        $this->customFactories[] = [$factory, $priority];

        return $this;
    }

    public function addAlias($alias, $identifier)
    {
        $this->aliases[$alias] = $identifier;

        return $this;
    }

    public function addInitializer(callable $initializer)
    {
        $this->initializers[] = $initializer;

        return $this;
    }

    public function addFlyweightCaching(callable $keyCalculator = null)
    {
        $this->flyweightCaching = $keyCalculator ?: true;

        return $this;
    }

    public function addIdentifierInflection($inflectionType = InflectionFactoryDecorator::CAMEL_CASE)
    {
        $this->identifierInflection = $inflectionType;

        return $this;
    }

    public function addIdentifierCallback(callable $callback)
    {
        $this->identifierCallback = $callback;

        return $this;
    }

    public function setRequiredOptions(array $requiredKeys)
    {
        $this->requiredKeys = $requiredKeys;

        return $this;
    }

    public function setDefaultOptions($options)
    {
        $this->defaultOptions = $options;

        return $this;
    }

    public function build()
    {
        $factories = $this->customFactories;

        if ($this->namespaces) {
            $factory = new NamespaceFactory($this->namespaces);
            $factories[] = array($factory, -50);
        }

        if ($this->classes) {
            $factory = new ClassMapFactory($this->classes);
            $factories[] = array($factory, -25);
        }

        if ($this->factories) {
            $factory = new FactoryMapFactory($this->factories);
            $factories[] = array($factory, 25);
        }

        if ($this->callbacks) {
            $factory = new CallbackFactory($this->callbacks);
            $factories[] = array($factory, 50);
        }

        $factoryCount = count($factories);
        if ($factoryCount > 1) {
            $factory = new CompositeFactory;
            foreach ($factories as $factoryInfo) {
                $factory->addFactory($factoryInfo[0], $factoryInfo[1]);
            }
        } elseif ($factoryCount === 1) {
            $factory = $factories[0][0];
        } else {
            throw new \RuntimeException('No factory object could be created from the provided configuration.');
        }

        if ($this->initializers) {
            $factory = new InitializerFactoryDecorator($factory, $this->initializers);
        }

        if ($this->identifierInflection) {
            $factory = new InflectionFactoryDecorator($factory, $this->identifierInflection);
        }

        if ($this->aliases) {
            $factory = new AliasFactoryDecorator($factory, $this->aliases);
        }

        if ($this->identifierCallback) {
            $factory = new IdentifierCallbackFactoryDecorator($factory, $this->identifierCallback);
        }

        if ($this->requiredKeys || $this->defaultOptions) {
            $factory = new RequiredOptionsFactoryDecorator($factory, $this->requiredKeys, $this->defaultOptions);
        }

        if ($this->flyweightCaching) {
            $factory = new FlyweightFactoryDecorator($factory);
            if (is_callable($this->flyweightCaching)) {
                $factory->setKeyCalculator($this->flyweightCaching);
            }
        }

        return $factory;
    }
}
