<?php

class Couch_Store implements Store {

    private $client;
    
    function __construct(
        CouchdbClient $client
    ) {
        $this->client = $client;
    }

    function saveDocument($document) {
        return $client->storeDoc($document);
    }
    
    function batchSave(array $documents) {
        return $client->storeDocs($documents);
    }
    
    function saveAttachment(
        string $doc_id,
        string $filename,
        string $attachment_name,
        string $content_type,
        string $doc_rev=null
    ) {
        return $client->storeAttachment(
            $doc_id,
            $filename,
            $attachment_name,
            $content_type,
            $doc_rev
        );
    }
}