<?php

class EtsyTaggle_PHP_Log_Processor_Message_Memcache implements EtsyTaggle_PHP_Log_Processor_Message {

    function process(&$document) {
        if (preg_match_all('@(/[^:]+):([0-9]+);@', $document->log_message, $matches)) {
            $document->stack_trace = array();
            foreach ($matches[1] as $k => $filename) {
                $reference = new StdClass;
                $reference->file = $filename;
                $reference->line = $matches[2][$k];
                $document->stack_trace[$k] = $reference;
            }
        }
    }
}
