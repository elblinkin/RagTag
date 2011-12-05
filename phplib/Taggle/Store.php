<?php

interface Taggle_Store {

    function getDocument($doc_id);
    
    function saveDocument($document);
    
    function batchSave(array $documents);
}