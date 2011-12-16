<?php

class Raggle_Printer_File {

    private $handle;
    
    function __construct(resource $handle) {
        $this->handle = $handle;
    }
    
    function print($message) {
        fwrite($this->handle, $message);
    }
}