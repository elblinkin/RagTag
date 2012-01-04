<?php

namespace RagTag\Printer;

class Console implements \RagTag\Printer {

    function write($message) {
        print $message;
    }
}