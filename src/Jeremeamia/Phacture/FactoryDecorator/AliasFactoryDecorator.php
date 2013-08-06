<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

class AliasFactoryDecorator extends AbstractFactoryDecorator
{
    /**
     * @var array
     */
    protected $aliases = [];

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

    public function create($identifier, $options = [])
    {
        $identifier = isset($this->aliases[$identifier]) ? $this->aliases[$identifier] : $identifier;

        return $this->innerFactory->create($identifier, $options);
    }

    public function canCreate($identifier)
    {
        $identifier = isset($this->aliases[$identifier]) ? $this->aliases[$identifier] : $identifier;

        return $this->innerFactory->canCreate($identifier);
    }
}
