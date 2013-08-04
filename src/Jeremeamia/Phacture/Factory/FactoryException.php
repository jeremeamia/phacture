<?php

namespace Jeremeamia\Phacture\Factory;

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
    private $fqcn;

    public function setName($name)
    {
        if (!$this->name) {
            $message = 'Could not instantiate an object using the provided alias';
            $message .= is_string($name) ? " \"{$name}\"." : '.';
            $this->message = $message . ($this->message ? ' ' . $this->message : '');
        }

        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setFqcn($fqcn)
    {
        $this->fqcn = $fqcn;

        return $this;
    }

    public function getFqcn()
    {
        return $this->fqcn;
    }
}
