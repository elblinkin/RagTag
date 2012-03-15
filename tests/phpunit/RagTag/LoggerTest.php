<?php

namespace RagTag;

require_once 'Autoload.php';

class LoggerTest extends \PHPUnit_Framework_TestCase {

    private $printer;
    private $logger;
    
    function setUp() {
        parent::setUp();
        $this->printer = $this->getMock('RagTag\Printer');
        $this->logger = new Logger(array($this->printer));
    }
    
    function testLogCommand() {
        $this->printer
            ->expects($this->at(0))
            ->method('write')
            ->with("+ ls -l\n");
        $this->printer
            ->expects($this->at(1))
            ->method('write')
            ->with("Return Value:  2\n");
            
        $this->logger->logCommand(array('+ ls -l'), 2);
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
        $printer_a = $this->getMock('RagTag\Printer');
        $printer_b = $this->getMock('RagTag\Printer');
        
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