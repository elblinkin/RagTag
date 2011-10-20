<?php

class Taggle_Jenkins_Console_Processor implements Taggle_Document_Processor {

    private $store;

    function __construct(Taggle_Store $store) {
        $this->store = $store;
    }

    function process($filename, $ref_id=null) {
        $this->store->saveAttachment(
            $ref_id,
            $filename,
            'log',
            'text/plain'
        );
    }
}
