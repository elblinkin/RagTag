<?php

class Taggle_Jenkins_Build_Processor implements Taggle_Document_Processor {

    private $store;

    function __construct(Taggle_Store $store) {
        $this->store = $store;
    }

    function process($filename, $ref_id=null) {
        $object = simplexml_load_file($filename);
        $object->taggle_type = 'jenkins-build';
        $json = json_encode($object);
        return $this->store->saveDocument($json);
    }
}