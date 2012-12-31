<?php

/*
 * Copyright (c) 2012 Orkestra Community
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

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
