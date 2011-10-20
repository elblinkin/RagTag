<?php

interface Taggle_Store {

    function saveDocument($document);
    
    function batchSave(array $documents);
    
    function saveAttachment(
        $doc_id,
        $filename,
        $attachment_name,
        $content_type,
        $doc_rev=null
    );
}