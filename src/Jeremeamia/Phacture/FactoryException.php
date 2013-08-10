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

    public function setContext($identifier, $options)
    {
        if (!$this->identifier) {
            $message = 'Could not create an object using the provided identifier';
            $message .= is_string($identifier) ? " \"{$identifier}\"." : '.';
            $this->message = $message . ($this->message ? ' ' . $this->message : '');
        }

        $this->identifier = $identifier;
        $this->options = $options;

        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getOptions()
    {
        return $this->options;
    }
}
