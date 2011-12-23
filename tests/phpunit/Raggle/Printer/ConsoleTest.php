<?php

namespace Raggle\Printer;

require_once 'Autoload.php';

class ConsoleTest extends \PHPUnit_Framework_TestCase {

    function testWrite() {
        $this->expectOutputString('Hello World');
        
        $printer = new Console();
        $printer->write('Hello World');
    }
}