<?php

class Raggle_Printer_Console implements Raggle_Printer {

    function write($message) {
        print $message;
    }
}