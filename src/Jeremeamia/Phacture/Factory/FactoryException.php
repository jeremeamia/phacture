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
    private $identifier;

    /**
     * @var mixed
     */
    private $options;

    public function setIdentifier($identifier)
    {
        if (!$this->identifier) {
            $message = 'Could not instantiate an object using the provided alias';
            $message .= is_string($identifier) ? " \"{$identifier}\"." : '.';
            $this->message = $message . ($this->message ? ' ' . $this->message : '');
        }

        $this->identifier = $identifier;

        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
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
}
