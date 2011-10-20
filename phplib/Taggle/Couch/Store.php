<?php

class Taggle_Couch_Store implements Taggle_Store {

    private $client;
    
    function __construct(
        CouchdbClient $client
    ) {
        $this->client = $client;
    }

    function saveDocument($document) {
        return $this->client->storeDoc($document);
    }
    
    function batchSave(array $documents) {
        return $this->client->storeDocs($documents);
    }
    
    function saveAttachment(
        $doc_id,
        $filename,
        $attachment_name,
        $content_type,
        $doc_rev=null
    ) {
        $document = $this->client->getDoc($doc_id);
        if (!isset($document->_attachments)) {
            $document->_attachments = array();
        }
        $document->_attachments[$attachment_name] =
            array(
                'content-type' => $content_type,
                'data' => base64_encode(file_get_contents($filename)),
            );
                  print_r(json_encode($document));
        return $this->saveDocument(json_encode($document));
    }
}