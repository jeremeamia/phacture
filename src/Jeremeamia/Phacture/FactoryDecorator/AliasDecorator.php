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

    public function __construct(FactoryInterface $innerFactory = null, array $aliases = array())
    {
        $this->innerFactory = $innerFactory ?: new ClassFactory;

        foreach ($aliases as $key => $value) {
            $this->addAlias($key, $value);
        }
    }

    /**
     * @param string $alias
     * @param string $identifier
     *
     * @return $this
     */
    public function addAlias($alias, $identifier)
    {
        $this->aliases[$alias] = $identifier;

        return $this;
    }

    public function doCreate($identifier, array $options)
    {
        return $this->innerFactory->create($this->aliases[$identifier], $options);
    }

    public function canCreate($identifier)
    {
        return isset($this->aliases[$identifier]);
    }
}
