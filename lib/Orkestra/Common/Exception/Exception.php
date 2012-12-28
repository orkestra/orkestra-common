<?php

namespace Orkestra\Common\Exception;

/**
 * Base class for any exception
 */
class Exception extends \Exception
{
    /**
     * Constructor
     *
     * Constructs a new Exception.
     *
     * @param string    $message        A message describing the exception
     * @param Exception $innerException The exception that occurred previous to this one
     * @param int       $code
     */
    public function __construct($message = "Undefined exception", $innerException = null, $code = 0)
    {
        parent::__construct($message, $code, $innerException);
    }

    /**
     * To String
     *
     * @return string
     */
     public function __toString()
     {
        return sprintf(
            "%s: '%s' in %s (ln. %s)\n\t%s",
            get_class($this),
            $this->message,
            $this->file,
            $this->line,
            str_replace(PHP_EOL, PHP_EOL . "\t", $this->getTraceAsString())
        );
    }
}
