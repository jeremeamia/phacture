<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\InflectsNamesTrait;

class IdentifierCallbackFactoryDecorator extends AbstractFactoryDecorator
{
    use InflectsNamesTrait;

    /**
     * @var callable
     */
    private $callback;

    public function __construct(FactoryDecoratorInterface $factory, callable $callback)
    {
        $this->callback = $callback;
    }

    public function create($identifier, $options = [])
    {
        return $this->innerFactory->create(call_user_func($this->callback, $identifier), $options);
    }

    public function canCreate($identifier)
    {
        return $this->innerFactory->canCreate(call_user_func($this->callback, $identifier));
    }
}
