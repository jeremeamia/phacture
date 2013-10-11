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
    private $name;

    /**
     * @var mixed
     */
    private $options;

    /**
     * @var string
     */
    private $factoryFqcn;

    public static function withContext($name, $options, $factoryFqcn)
    {
        $class = substr($factoryFqcn, strrpos($factoryFqcn, '\\') + 1);
        $message = "The {$class} could not create an object using the provided name: \"{$name}\".";
        $exception = new self($message);

        $exception->name = $name;
        $exception->options = $options;
        $exception->factoryFqcn = $factoryFqcn;

        return $exception;
    }

    public function getName()
    {
        return $this->name;
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
