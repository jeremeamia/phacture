<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Factory\ClassFactory;
use Jeremeamia\Phacture\FactoryInterface;

class InflectionDecorator extends BaseDecorator
{
    const CAMEL_CASE = 'camel-case';
    const SNAKE_CASE = 'snake-case';

    /**
     * @var string
     */
    protected $inflectionType;

    /**
     * @param FactoryInterface $innerFactory
     * @param string           $inflectionType
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(FactoryInterface $innerFactory = null, $inflectionType = self::CAMEL_CASE)
    {
        $this->innerFactory = $innerFactory ?: new ClassFactory;

        if ($inflectionType === self::CAMEL_CASE || $inflectionType === self::SNAKE_CASE) {
            $this->inflectionType = $inflectionType;
        } else {
            throw new \InvalidArgumentException('You must provide a valid inflection type.');
        }
    }

    public function doCreate($identifier, array $options)
    {
        return $this->innerFactory->create($this->inflect($identifier), $options);
    }

    protected function inflect($word)
    {
        if ($this->inflectionType === self::CAMEL_CASE) {
            return str_replace(' ', '', ucwords(strtr($word, '_-', '  ')));
        } else {
            return ctype_lower($word) ? $word : strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $word));
        }
    }
}
