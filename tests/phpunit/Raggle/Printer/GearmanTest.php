<?php

require_once 'Autoload.php';

class Raggle_Printer_GearmanTest extends PHPUnit_Framework_TestCase {

    function testWrite() {
        $job = $this->getMock('GearmanJob');
        $job
            ->expects($this->once())
            ->method('sendData')
            ->with('Hello World');
            
        $printer = new Raggle_Printer_Gearman($job);
        $printer->write('Hello World');
    }
}
