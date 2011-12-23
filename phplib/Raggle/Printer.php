<?php

namespace Raggle;

interface Printer {

    /**
     * Writes the message to whatever the underlying logging mechanism is.
     *
     * @param string $message message to write out to the underlying mechanism.
     */
    function write($message);
}