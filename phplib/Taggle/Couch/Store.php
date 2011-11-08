<?php

class Taggle_Couch_Store implements Taggle_Store {

    private $client;
    
    function __construct(
        CouchdbClient $client
    ) {
        $this->client = $client;
    }

    function getDocument($doc_id) {
        return $this->client->getDoc($doc_id);
    }
    
    function saveDocument($document) {
        return $this->client->storeDoc(json_encode($document));
    }
    
    function batchSave(array $documents) {
        return $this->client->storeDocs($documents);
    }
}