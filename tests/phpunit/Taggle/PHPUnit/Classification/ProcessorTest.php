<?php

namespace Taggle\PHPUnit\Classification;

require_once 'Autoload.php';
require_once 'vfsStream/vfsStream.php';

use Mockery;
use vfsStream;
use vfsStreamWrapper;

class ProcessorTest extends \PHPUnit_Framework_TestCase {

    private $store;
    private $processor;
    
    function setUp() {
        parent::setUp();
        vfsStream::setup('processorTest');
        $this->store = Mockery::mock('\Taggle\Store');
        $this->processor = new Processor($this->store);
    }
    
    function tearDown() {
        Mockery::close();
        parent::tearDown();
    }
    
    function testProcess_empty() {
        vfsStream::newFile('classification.json')->at(vfsStreamWrapper::getRoot());
        $url = vfsStream::url('processorTest/classification.json');
        $this->store
            ->shouldReceive('batchSave')
            ->with(array())
            ->once()
            ->andReturn(array());
        $this->assertEmpty($this->processor->process($url));
    }
    
    function testProcess_file() {
        $content = '{"suite":"Taggle\\\PHPUnit\\\Classification\\\ProcessorTest",'
            . '"test":"Taggle\\\PHPUnit\\\Classification\\\ProcessorTest::testProcess_empty",'
            . '"file_name":"\/Users\/laurabethlincoln\/Taggle\/tests\/phpunit\/Taggle\/PHPUnit\/Classification\/ProcessorTest.php",'
            . '"start_line":29,'
            . '"end_line":38,'
            . '"exec_status":"executed",'
            . '"annotations":[]}';
        $content2 = '{"suite":"Taggle\\\PHPUnit\\\Classification\\\ProcessorTest",'
            . '"test":"Taggle\\\PHPUnit\\\Classification\\\ProcessorTest::testProcess_file",'
            . '"file_name":"\/Users\/laurabethlincoln\/Taggle\/tests\/phpunit\/Taggle\/PHPUnit\/Classification\/ProcessorTest.php",'
            . '"start_line":40,'
            . '"end_line":61,'
            . '"exec_status":"executed",'
            . '"annotations":[]}';
        $document = json_decode($content);
        $document->taggle_type = 'phpunit_classification';
        $document->ref_id = '12345';
        $document2 = json_decode($content2);
        $document2->taggle_type = 'phpunit_classification';
        $document2->ref_id = '12345';
        vfsStream::newFile('classification.json')
            ->withContent($content . $content2)
            ->at(vfsStreamWrapper::getRoot());
        $url = vfsStream::url('processorTest/classification.json');
        $this->store
            ->shouldReceive('batchSave')
            ->with(array($document, $document2))
            ->once()
            ->andReturn(array('24680', '24681'));
        $this->assertEquals(array('24680', '24681'), $this->processor->process($url, '12345'));
    }
}