<?php

namespace Raggle;

require_once 'Autoload.php';

class LoggerTest extends \PHPUnit_Framework_TestCase {

    private $printer;
    private $logger;
    
    function setUp() {
        parent::setUp();
        $this->printer = $this->getMock('Raggle\Printer');
        $this->logger = new Logger(array($this->printer));
    }
    
    function testLogCommand() {
        $this->printer
            ->expects($this->once())
            ->method('write')
            ->with(" + ls -l\n");
            
        $this->logger->logCommand('ls -l');
    }
    
    function testLogReturn_noOutput() {
        $this->printer
            ->expects($this->once())
            ->method('write')
            ->with("\tReturn Value:  215\n");
        
        $this->logger->logReturn(array(), 215);
    }
    
    function testLogReturn_multiLine() {
        $this->printer
            ->expects($this->exactly(3))
            ->method('write')
            ->with($this->logicalOr("\tfoo\n", "\tbar\n", "\tReturn Value:  215\n"));
            
        $this->logger->logReturn(array('foo', 'bar'), 215);
    }
    
    function testLogInfo() {
        $this->printer
            ->expects($this->once())
            ->method('write')
            ->with("[INFO] This is an info message.\n");
           
        $this->logger->logInfo('This is an info message.');
    }
    
    function testLogError() {
        $this->printer
            ->expects($this->once())
            ->method('write')
            ->with("[ERROR] This is an error message.\n");
            
        $this->logger->logError('This is an error message.');
    }
    
    function testLogError_teed() {
        $printer_a = $this->getMock('Raggle\Printer');
        $printer_b = $this->getMock('Raggle\Printer');
        
        $printer_a
            ->expects($this->once())
            ->method('write')
            ->with("[ERROR] This is an error message.\n");
        
        $printer_b
            ->expects($this->once())
            ->method('write')
            ->with("[ERROR] This is an error message.\n");
         
        $logger = new Logger(array($printer_a, $printer_b));
        
        $logger->logError('This is an error message.');
    }
}