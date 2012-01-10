<?php

namespace Taggle\Git\Log;

use Mockery;
use StdClass;

require_once 'Autoload.php';

class ProcessorTest extends \PHPUnit_Framework_TestCase {

    private $store;
    private $processor;
    
    function setUp() {
        parent::setUp();
        $this->store = Mockery::mock('\Taggle\Store');
        $this->processor = new Processor($this->store);
    }
    
    function tearDown() {
        Mockery::close();
        parent::tearDown();
    }
    
    function testProcess_emtpyLogOutput() {
        $this->store
            ->shouldReceive('batchSave')
            ->with(array())
            ->once()
            ->andReturn(array());
        $this->assertEmpty($this->processor->process(array()));
    }
    
    function testProcess_singleLog() {
        $json = '{"commit": "f260be1c11bd0070a41da2cbc3fdb5f81782d604", '
            . '"author": '
            . '{"name": "Laura Beth Lincoln", '
            . '"email": "llincoln@etsy.com", '
            . '"date":"1326136967"}, '
            . '"committer": '
            . '{"name": "Laura Beth Lincoln", '
            . '"email": "llincoln@etsy.com", '
            . '"date": "1326136967"}, '
            . '"message": "Add test for the CouchDB Store."}';
        $doc_ids = array('24680');
        $document =  json_decode($json);
        $document->ref_id = '12345';
        $document->files = array(
            'phplib/Taggle/Couch/Store.php',
            'phplib/Taggle/Store.php',
            'tests/phpunit/Taggle/Couch/StoreTest.php',
        );
                
        $documents = array($document);
        $this->store
            ->shouldReceive('batchSave')
            ->with(array($document))
            ->once()
            ->andReturn($doc_ids);
        $log = array(
            $json,
            'phplib/Taggle/Couch/Store.php',
            'phplib/Taggle/Store.php',
            'tests/phpunit/Taggle/Couch/StoreTest.php',
        );
        $this->assertEquals($doc_ids, $this->processor->process($log, '12345'));
    }
    
    function testProcess_multipleLogs() {
        $json = '{"commit": "f260be1c11bd0070a41da2cbc3fdb5f81782d604", '
            . '"author": '
            . '{"name": "Laura Beth Lincoln", '
            . '"email": "llincoln@etsy.com", '
            . '"date":"1326136967"}, '
            . '"committer": '
            . '{"name": "Laura Beth Lincoln", '
            . '"email": "llincoln@etsy.com", '
            . '"date": "1326136967"}, '
            . '"message": "Add test for the CouchDB Store."}';
        $json2 = '{"commit": "b23eb8d37b50c6f335f90236aea5065255274bce", '
            . '"author": '
            . '"name": "Laura Beth Lincoln", '
            . '"email": "llincoln@etsy.com", '
            . '"date":"1325863603"}, '
            . '"committer": '
            . '{"name": "Laura Beth Lincoln", '
            . '"email": "llincoln@etsy.com", '
            . '"date": "1325863603"}, '
            . '"message": "PSR 0 compliance and test."}';

        $doc_ids = array('24680', '24681');
        $document =  json_decode($json);
        $document->ref_id = '12345';
        $document->files = array(
            'phplib/Taggle/Couch/Store.php',
            'phplib/Taggle/Store.php',
            'tests/phpunit/Taggle/Couch/StoreTest.php',
        );
        $document2 = json_decode($json2);
        $document2->ref_id = '12345';
        $document2->files = array(
            'phplib/Taggle/Blamer/Git.php',
            'tests/phpunit/Taggle/Blamer/GitTest.php',
        );
                
        $documents = array($document);
        $this->store
            ->shouldReceive('batchSave')
            ->with(array($document, $document2))
            ->once()
            ->andReturn($doc_ids);
        $log = array(
            $json,
            'phplib/Taggle/Couch/Store.php',
            'phplib/Taggle/Store.php',
            'tests/phpunit/Taggle/Couch/StoreTest.php',
            '',
            $json2,
            'phplib/Taggle/Blamer/Git.php',
            'tests/phpunit/Taggle/Blamer/GitTest.php',
        );
        $this->assertEquals($doc_ids, $this->processor->process($log, '12345'));
    }
}
