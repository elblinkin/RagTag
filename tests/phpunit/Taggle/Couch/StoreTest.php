<?php

namespace Taggle\Couch;

require_once 'Autoload.php';

use \Mockery;

class StoreTest extends \PHPUnit_Framework_TestCase {

    private $doc_id;
    private $document;
    
    private $actual_client;
    private $client;
    private $store;
    
    function setUp() {
        parent::setUp();
        $this->doc_id = '13579';
        $this->documents = new \StdClass;
        $this->document->_id = $this->doc_id;
        
        $this->actual_client = new \CouchdbClient('http://localhost:5984');
        $this->client = Mockery::mock($this->actual_client);
            
        $this->store = new Store($this->client);
    }
    
    function tearDown() {
        parent::tearDown();
        unset($this->actual_client);
        Mockery::close();
    }
    
    function testGetDocument() {
        $this->client
            ->shouldReceive('getDoc')
            ->with($this->doc_id)
            ->once()
            ->andReturn($this->document);
            
        $this->assertEquals(
            $this->document,
            $this->store->getDocument($this->doc_id)
        );
    }
    
    function testSaveDocument() {
        $this->client
            ->shouldReceive('storeDoc')
            ->with(json_encode($this->document))
            ->once()
            ->andReturn($this->doc_id);
            
        $this->assertEquals(
            $this->doc_id,
            $this->store->saveDocument($this->document)
        );
    }
    
    function testBatchSave() {
        $doc_id2 = '24680';
        $document2 = new \StdClass;
        $document2->_id = $doc_id2;
        
        $doc_ids = array($this->doc_id, $doc_id2);
        $documents = array($this->document, $document2);
        
        $this->client
            ->shouldReceive('storeDocs')
            ->with($documents)
            ->once()
            ->andReturn($doc_ids);
            
        $this->assertEquals(
            $doc_ids,
            $this->store->batchSave($documents)
        );
    }
}
