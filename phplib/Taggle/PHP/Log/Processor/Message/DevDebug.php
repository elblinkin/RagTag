<?php

class Taggle_PHP_Log_Processor_Message_DevDebug implements Taggle_PHP_Log_Processor_Message {

    function process(&$document) {
       if ($document->log_namespace === 'DEV_DEBUG') {
           if (preg_match_all('@(/[^\\s]+\.php) (on line|line) ([0-9]+)@', $document->log_message, $matches)) {
               $document->references = array();
               $reference = new StdClass;
               foreach ($matches[1] as $k => $filename) {
                   $reference->file = $filename;
                   $document->references[$k] = $reference;
               }
               foreach ($matches[3] as $k => $line_number) {
                    $document->references[$k]->line = $line_number;
                }
            }
        }
    }
}