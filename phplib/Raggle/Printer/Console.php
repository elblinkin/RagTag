<?php

namespace Raggle\Printer;

class Console implements \Raggle\Printer {

    function write($message) {
        print $message;
    }
}