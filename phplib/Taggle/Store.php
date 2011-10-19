<?php

interface Store {

    function saveDocument($document);
    
    function batchSave(array $documents);
    
    function saveAttachment(
        string $doc_id,
        string $filename,
        string $attachment_name,
        string $content_type,
        string $doc_rev=null
    );
}