<?php

namespace RagTag\Printer;

class File implements \RagTag\Printer {

    private $handle;
    
    function __construct($handle) {
        $this->handle = $handle;
    }
    
    function write($message) {
        fwrite($this->handle, $message);
    }
}