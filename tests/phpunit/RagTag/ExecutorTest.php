<?php

namespace RagTag;

require_once 'Autoload.php';

class ExecutorTest extends \PHPUnit_Framework_TestCase {

    private $logger;
    private $exec;
    
    protected function setUp() {
        parent::setUp();
        $this->logger = $this->getMockBuilder('RagTag\Logger')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->exec = new Executor($this->logger);
    }
    
    function testExecute_defaults() {
        $this->logger
            ->expects($this->any())
            ->method('logCommand')
            ->with('echo testing');
        $this->logger
            ->expects($this->any())
            ->method('logReturn')
            ->with(array('testing'), 0);
            
        $this->exec->execute('echo testing');
    }
    
    function testExecute_captureOutput() {
        $this->logger
            ->expects($this->any())
            ->method('logCommand')
            ->with('echo testing');
        $this->logger
            ->expects($this->any())
            ->method('logReturn')
            ->with(array('testing'), 0);
            
        $this->exec->execute('echo testing', $output);
        $this->assertEquals(array('testing'), $output);
    }
    
    function testExecute_captureReturnValue() {
        $this->logger
            ->expects($this->any())
            ->method('logCommand')
            ->with('echo testing');
        $this->logger
            ->expects($this->any())
            ->method('logReturn')
            ->with(array('testing'), 0);
            
        $this->exec->execute('echo testing', $output, $return_value);
        $this->assertEquals(0, $return_value);
    }
}