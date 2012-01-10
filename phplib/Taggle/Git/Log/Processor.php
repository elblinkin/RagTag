<?php

namespace Taggle\Git\Log;

class Processor implements \Taggle\Document\Processor {

    private $store;
    
    function __construct(/*\Taggle\Store*/ $store) {
        $this->store = $store;
    }

    function process($log_output, $ref_id = null) {
        $documents = array();
        $log = null;
        foreach ($log_output as $line) {
            if ($log == null) {
                $log = json_decode($line);
                $log->ref_id = $ref_id;
                $log->files = array();
            } else if (empty($line)) {
                $documents[] = $log;
                $log = null;
            } else {
                $log->files[] = $line;
            }
        }
        if ($log != null) {
            $documents[] = $log;
        }
        return $this->store->batchSave($documents);
    }
}

