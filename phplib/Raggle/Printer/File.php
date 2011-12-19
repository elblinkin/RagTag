<?php

class Raggle_Printer_File {

    private $handle;
    
    function __construct($handle) {
        $this->handle = $handle;
    }
    
    function write($message) {
        fwrite($this->handle, $message);
    }
}