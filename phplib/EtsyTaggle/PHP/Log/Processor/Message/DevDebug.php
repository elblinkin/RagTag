<?php

class EtsyTaggle_PHP_Log_Processor_Message_DevDebug implements EtsyTaggle_PHP_Log_Processor_Message {

    function process(&$document) {
       if ($document->log_namespace === 'DEV_DEBUG') {
           if (preg_match_all('@(/[^\\s]+) (on line|line) ([0-9]+)@', $document->log_message, $matches)) {
               $document->references = array();
               foreach ($matches[1] as $k => $filename) {
                   $reference = new StdClass;
                   $reference->file = $filename;
                   $reference->line = $matches[3][$k];
                   $document->references[$k] = $reference;
               }
            }
        }
    }
}
