<?php

class Taggle_PHP_Log_Processor_Message_Stacktrace implements Taggle_PHP_Log_Processor_Message {

    function process(&$document) {
        if (preg_match_all('@\\#[0-9]+ (/[^\\s]+\.php)\\(([0-9]+)\\):@', $document->log_message, $matches)) {
            $document->references = array();
            foreach ($matches[1] as $k => $filename) {
                $reference = new StdClass;
                $reference->file = $filename;
                $reference->line = $matches[2][$k];
                $document->references[$k] = $reference;
            }
        }
    }
}