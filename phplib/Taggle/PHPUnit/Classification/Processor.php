<?php

namespace Taggle\PHPUnit\Classification;

use Taggle\Store;

class Processor implements \Taggle\Document\Processor {

    private $store;

    function __construct(Store $store) {
        $this->store = $store;
    }

    function process($filename, $ref_id=null) {
        $documents = array();
        $contents = file_get_contents($filename);
        $json = '[' . preg_replace("/}\n?{/", '},{', $contents) .']';
        $messages = json_decode($json);
        foreach ($messages as $message) {
            $message->taggle_type = 'phpunit_classification';
            $message->ref_id = $ref_id;
            $documents[] = $message;
        }
        return $this->store->batchSave($documents);
    }
}