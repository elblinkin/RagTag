<?php

require_once 'Autoload.php';

class Raggle_ExecTest extends PHPUnit_Framework_TestCase {

    private $logger;
    private $exec;
    
    protected function setUp() {
        parent::setUp();
        $this->logger = $this->getMockBuilder('Raggle_Logger')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->exec = new Raggle_Exec($this->logger);
    }
    
    function testExecute_defaults() {
        $this->logger
            ->expects($this->any())
            ->method('logExec')
            ->with('echo testing', array('testing'), 0);
            
        $this->exec->execute('echo testing');
    }
    
    function testExecute_captureOutput() {
        $this->logger
            ->expects($this->any())
            ->method('logExec')
            ->with('echo testing', array('testing'), 0);
            
        $this->exec->execute('echo testing', $output);
        $this->assertEquals(array('testing'), $output);
    }
    
    function testExecute_captureReturnValue() {
        $this->logger
            ->expects($this->any())
            ->method('logExec')
            ->with('echo testing', array('testing'), 0);
            
        $this->exec->execute('echo testing', $output, $return_value);
        $this->assertEquals(0, $return_value);
    }
}