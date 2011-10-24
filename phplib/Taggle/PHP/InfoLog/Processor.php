<?php

class Taggle_PHP_InfoLog_Processor implements Taggle_Document_Processor {

    const DEBUG_REGEX = '@\[(.*)\] \[(.*)\] \[debug\] \[(.*)\] \[(.*)\] \[(.*)\] (.*)@';
    const INFO_REGEX = '@\[(.*)\] \[(.*)\] \[info\] \[(.*)\] \[(.*)\] (.*)@';
    
    const LOG_DATE = 1;
    const LOG_ID = 2;
    const LOG_NAMESPACE = 3;
    const FILE_LINE = 4;
    
    const DEBUG_MESSAGE = 6;
    const INFO_MESSAGE = 5;

    private $store;

    function __construct(
        Taggle_Store $store
    ) {
        $this->store = $store;
    }
    
    function process($document, $ref_id=null) {
        $documents = array();
        $handle = fopen($document, 'r');
        while(($line = fgets($handle, 4096 * 3)) !== false) {
            $document = new StdClass;
            $document->raw = $line;
            $document->ref_id = $ref_id;
            $document->taggle_type = 'php_infolog';
            
            if (preg_match(self::DEBUG_REGEX, $line, $matches)) {
                $document->log_date = $matches[self::LOG_DATE];
                $document->log_id = $matches[self::LOG_ID];
                $document->log_level = 'debug';
                $document->log_namespace = $matches[self::LOG_NAMESPACE];
            
                $file_line = explode(':', $matches[self::FILE_LINE]);
                $document->source = new StdClass;
                $document->source->file = $file_line[0];
                $document->source->line = $file_line[1];
                
                $document->log_message = $matches[self::DEBUG_MESSAGE];
            } else if (preg_match(self::INFO_REGEX, $line, $matches)) {
                $document->log_date = $matches[self::LOG_DATE];
                $document->log_id = $matches[self::LOG_ID];
                $document->log_level = 'info';
                $document->log_namespace = $matches[self::LOG_NAMESPACE];
                
                $document->log_message = $matches[self::INFO_MESSAGE];
            }
            $documents[] = $document;
        }
        fclose($handle);
        return $this->store->batchSave($documents);
    }
}