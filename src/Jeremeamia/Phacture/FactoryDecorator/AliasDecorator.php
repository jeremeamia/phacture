<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Factory\ClassFactory;
use Jeremeamia\Phacture\FactoryInterface;

class AliasDecorator extends BaseDecorator
{
    /**
     * @var array
     */
    protected $aliases = array();

    /**
     * @param FactoryInterface $innerFactory
     * @param array            $aliases
     */
    public function __construct(FactoryInterface $innerFactory = null, array $aliases = array())
    {
        $this->innerFactory = $innerFactory ?: new ClassFactory;

        foreach ($aliases as $key => $value) {
            $this->addAlias($key, $value);
        }
    }

    /**
     * @param string $alias
     * @param string $name
     *
     * @return $this
     */
    public function addAlias($alias, $name)
    {
        $this->aliases[$alias] = $name;

        return $this;
    }

    public function doCreate($name, array $options)
    {
        if (isset($this->aliases[$name])) {
            $name = $this->aliases[$name];
        }

        return $this->innerFactory->create($name, $options);
    }
}
