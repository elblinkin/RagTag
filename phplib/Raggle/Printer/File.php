<?php

namespace Raggle\Printer;

class File implements \Raggle\Printer {

    private $handle;
    
    function __construct($handle) {
        $this->handle = $handle;
    }
    
    function write($message) {
        fwrite($this->handle, $message);
    }
}