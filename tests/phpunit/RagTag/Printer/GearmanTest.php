<?php

namespace RagTag\Printer;

require_once 'Autoload.php';

class GearmanTest extends \PHPUnit_Framework_TestCase {

    function testWrite() {
        $job = $this->getMock('GearmanJob');
        $job
            ->expects($this->once())
            ->method('sendData')
            ->with('Hello World');
            
        $printer = new Gearman($job);
        $printer->write('Hello World');
    }
}
