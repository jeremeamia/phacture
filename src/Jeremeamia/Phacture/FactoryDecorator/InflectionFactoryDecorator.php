<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\InflectsNamesTrait;

class InflectionFactoryDecorator extends AbstractFactoryDecorator
{
    use InflectsNamesTrait;

    const CAMEL_CASE = 'camel-case';
    const SNAKE_CASE = 'snake-case';

    private $inflectionType;

    public function __construct(FactoryDecoratorInterface $factory, $inflectionType = self::CAMEL_CASE)
    {
        if ($inflectionType === self::CAMEL_CASE || $inflectionType === self::SNAKE_CASE) {
            $this->inflectionType = $inflectionType;
        } else {
            throw new \InvalidArgumentException('You must provide a valid inflection type.');
        }
    }

    public function create($identifier, $options = [])
    {
        return $this->innerFactory->create($this->inflect($identifier), $options);
    }

    public function canCreate($identifier)
    {
        return $this->innerFactory->canCreate($this->inflect($identifier));
    }

    private function inflect($identifier)
    {
        if ($this->inflectionType === self::CAMEL_CASE) {
            return $this->toCamelCase($identifier);
        } else {
            return $this->toSnakeCase($identifier);
        }
    }
}
