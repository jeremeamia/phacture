<?php

namespace Jeremeamia\Phacture;

use Jeremeamia\Phacture\BuilderInterface;
use Jeremeamia\Phacture\Factory\CallbackFactory;
use Jeremeamia\Phacture\Factory\ClassFactory;
use Jeremeamia\Phacture\Factory\ClassMapFactory;
use Jeremeamia\Phacture\Factory\FactoryMapFactory;
use Jeremeamia\Phacture\Factory\NamespaceFactory;
use Jeremeamia\Phacture\FactoryDecorator\AliasDecorator;
use Jeremeamia\Phacture\FactoryDecorator\BranchingDecorator;
use Jeremeamia\Phacture\FactoryDecorator\FlyweightDecorator;
use Jeremeamia\Phacture\FactoryDecorator\InflectionDecorator;
use Jeremeamia\Phacture\FactoryDecorator\InitializerDecorator;
use Jeremeamia\Phacture\FactoryDecorator\NameTransformerDecorator;
use Jeremeamia\Phacture\FactoryDecorator\OptionsTransformerDecorator;
use Jeremeamia\Phacture\FactoryDecorator\RequiredOptionsDecorator;

class FactoryBuilder implements BuilderInterface
{
    protected $factories = array();
    protected $callbacks = array();
    protected $classes = array();
    protected $namespaces = array();
    protected $aliases = array();
    protected $initializers = array();
    protected $requiredKeys = array();
    protected $defaultOptions = array();
    protected $flyweightCaching;
    protected $nameInflection;
    protected $nameTransformer;
    protected $optionsTransformer;

    public static function newInstance()
    {
        return new static;
    }

    public function addClass($name, $fqcn)
    {
        $this->classes[$name] = $fqcn;

        return $this;
    }

    public function addClasses(array $classes)
    {
        $this->classes = $classes + $this->classes;

        return $this;
    }

    public function addFactory($name, $factory)
    {
        $this->factories[$name] = $factory;

        return $this;
    }

    public function addFactories(array $factories)
    {
        $this->factories = $factories + $this->factories;

        return $this;
    }

    public function addAlias($alias, $name)
    {
        $this->aliases[$alias] = $name;

        return $this;
    }

    public function addAliases(array $aliases)
    {
        $this->aliases = $aliases + $this->aliases;
    }

    public function addNamespace($namespace)
    {
        $this->namespaces[] = $namespace;

        return $this;
    }

    public function addNamespaces(array $namespaces)
    {
        $this->namespaces = $namespaces + $this->namespaces;

        return $this;
    }

    public function addCallback($name, callable $callback)
    {
        $this->callbacks[$name] = $callback;

        return $this;
    }

    public function addInitializer($initializer)
    {
        $this->initializers[] = $initializer;

        return $this;
    }

    public function addFlyweightCaching($keyCalculator = null)
    {
        $this->flyweightCaching = $keyCalculator ?: true;

        return $this;
    }

    public function addNameInflection($inflectionType = InflectionDecorator::CAMEL_CASE)
    {
        $this->nameInflection = $inflectionType;

        return $this;
    }

    public function addNameTransformer($callback)
    {
        $this->nameTransformer = $callback;

        return $this;
    }

    public function addOptionsTransformer($callback)
    {
        $this->optionsTransformer = $callback;

        return $this;
    }

    public function addRequiredOptions(array $requiredKeys)
    {
        $this->requiredKeys = $requiredKeys + $this->requiredKeys;

        return $this;
    }

    public function addDefaultOptions(array $defaultOptions)
    {
        $this->defaultOptions = $defaultOptions + $this->defaultOptions;

        return $this;
    }

    public function build()
    {
        $factory = $classFactory = new ClassFactory;

        if ($this->namespaces) {
            $factory = new NamespaceFactory($this->namespaces, $classFactory);
        }

        if ($this->classes) {
            $classMapFactory = new ClassMapFactory($this->classes, $classFactory);
            $factory = new BranchingDecorator($classMapFactory, $factory);
        }

        if ($this->factories) {
            $factoryMapFactory = new FactoryMapFactory($this->factories);
            $factory = new BranchingDecorator($factoryMapFactory, $factory);
        }

        if ($this->callbacks) {
            $callbackFactory = new CallbackFactory($this->callbacks);
            $factory = new BranchingDecorator($callbackFactory, $factory);
        }

        if ($this->initializers) {
            $factory = new InitializerDecorator($factory, $this->initializers);
        }

        if ($this->aliases) {
            $factory = new AliasDecorator($factory, $this->aliases);
        }

        if ($this->optionsTransformer) {
            $factory = new OptionsTransformerDecorator($factory, $this->optionsTransformer);
        }

        if ($this->nameTransformer) {
            $factory = new NameTransformerDecorator($factory, $this->nameTransformer);
        }

        if ($this->nameInflection) {
            $factory = new InflectionDecorator($factory, $this->nameInflection);
        }

        if ($this->requiredKeys || $this->defaultOptions) {
            $factory = new RequiredOptionsDecorator($factory, $this->requiredKeys, $this->defaultOptions);
        }

        if ($this->flyweightCaching) {
            $keyCalculator = is_callable($this->flyweightCaching) ? $this->flyweightCaching : null;
            $factory = new FlyweightDecorator($factory, $keyCalculator);
        }

        return $factory;
    }
}
