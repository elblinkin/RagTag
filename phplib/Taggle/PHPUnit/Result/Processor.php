<?php

class Taggle_PHPUnit_Result_Processor implements Taggle_Document_Processor {

    private $store;

    function __construct(Taggle_Store $store) {
        $this->store = $store;
    }

    function process($filename, $ref_id=null) {
        $documents = array();
        $contents = file_get_contents($filename);
        $json = '[' . str_replace('}{', '},{', $contents) .']';
        $messages = json_decode($json);
        foreach ($messages as $message) {
            $message->taggle_type = 'phpunit_result';
            $message->ref_id = $ref_id;
            $documents[] = $message;
        }
        return $this->store->batchSave($documents);
    }
}