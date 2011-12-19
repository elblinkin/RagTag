<?php

require_once 'Autoload.php';

class Raggle_Printer_ConsoleTest extends PHPUnit_Framework_TestCase {

    function testWrite() {
        $this->expectOutputString('Hello World');
        
        $printer = new Raggle_Printer_Console();
        $printer->write('Hello World');
    }
}