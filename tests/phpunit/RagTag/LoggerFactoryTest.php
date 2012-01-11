<?php

namespace RagTag;

require_once 'Autoload.php';
require_once 'vfsStream/vfsStream.php';

use Mockery;
use vfsStream;
use vfsStreamWrapper;

class LoggerFactoryTest extends \PHPUnit_Framework_TestCase {

    private $factory;
    
    function setUp() {
        parent::setUp();
        $this->factory = new LoggerFactory();
    }
    
    function testCreate_noArgs() {
        $logger = $this->factory->create();
        $this->assertInstanceOf('\RagTag\Logger', $logger);
        return $logger;
    }
    
    /**
     * @depends testCreate_noArgs
     */
    function testCreate_noArgsPrintsToConsole($logger) {
        $this->expectOutputString("[INFO] Hello World!\n");
        $logger->logInfo('Hello World!');
    }
    
    function testCreate_logFile() {
        vfsStream::setup('fileTest');
        vfsStream::newFile('console.log')->at(vfsStreamWrapper::getRoot());
        $filename = vfsStream::url('fileTest/console.log');
        $fp = fopen($filename, 'a');
        $logger = $this->factory->create($fp);
        $this->assertInstanceOf('\RagTag\Logger', $logger);
        return $logger;
    }
    
    /**
     * @depends testCreate_logFile
     */
    function testCreate_logFilePrintsToFile($logger) {
        $filename = vfsStream::url('fileTest/console.log');
        $logger->logInfo('Hello World!');
        $this->assertEquals("[INFO] Hello World!\n", file_get_contents($filename));
    }
    
    function testCreate_gearman() {
        $job = Mockery::mock('\GearmanJob');
        $job
            ->shouldReceive('sendData')
            ->with("[INFO] Hello World!\n")
            ->once();
            
        $logger = $this->factory->create(null, $job);
        $this->assertInstanceOf('\RagTag\Logger', $logger);
        
        $logger->logInfo('Hello World!');
    }
    
    function testCreate_all() {
        $this->expectOutputString("[INFO] Hello World!\n");
        
        vfsStream::setup('fileTest');
        vfsStream::newFile('console.log')->at(vfsStreamWrapper::getRoot());
        $filename = vfsStream::url('fileTest/console.log');
        $fp = fopen($filename, 'a');
        
        $job = Mockery::mock('\GearmanJob');
        $job
            ->shouldReceive('sendData')
            ->with("[INFO] Hello World!\n")
            ->once();
            
        $logger = $this->factory->create($fp, $job);
        $this->assertInstanceOf('\RagTag\Logger', $logger);
        
        $logger->logInfo('Hello World!');
        $this->assertEquals("[INFO] Hello World!\n", file_get_contents($filename));
    }
}
