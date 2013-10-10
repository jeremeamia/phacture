<?php

namespace Jeremeamia\Phacture;

/**
 * An exception thrown when an object creation fails
 */
class FactoryException extends \RuntimeException
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var mixed
     */
    private $options;

    /**
     * @var string
     */
    private $factoryFqcn;

    public static function withContext($identifier, $options, $factoryFqcn)
    {
        $class = substr($factoryFqcn, strrpos($factoryFqcn, '\\') + 1);
        $message = "The {$class} could not create an object using the provided identifier: \"{$identifier}\".";
        $exception = new self($message);

        $exception->identifier = $identifier;
        $exception->options = $options;
        $exception->factoryFqcn = $factoryFqcn;

        return $exception;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getFactoryFqcn()
    {
        return $this->factoryFqcn;
    }
}
