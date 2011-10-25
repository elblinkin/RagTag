<?php

class Taggle_PHP_Log_Processor_Level_Other implements Taggle_PHP_Log_Processor_Level {

    const REGEX = '@\[(.*)\] \[(.*)\] \[(.*)\] \[(.*)\] \[(.*)\] \[(.*)\] (.*)@';
    
    const LOG_DATE = 1;
    const LOG_ID = 2;
    const LOG_LEVEL = 3;
    const LOG_NAMESPACE = 4;
    const FILE_LINE = 5;
    
    const LOG_MESSAGE = 7;
    
    private $message_processors;
    
    function __construct(
        array $message_processors
    ) {
        $this->message_processors = $message_processors;
    }
    
    function process($line, &$document) {
        if (preg_match(self::REGEX, $line, $matches)) {
            $document->log_date = $matches[self::LOG_DATE];
            $document->log_id = $matches[self::LOG_ID];
            $document->log_level = $matches[self::LOG_LEVEL];
            $document->log_namespace = $matches[self::LOG_NAMESPACE];
            
            $file_line = explode(':', $matches[self::FILE_LINE]);
            $document->source = new StdClass;
            $document->source->file = $file_line[0];
            $document->source->line = $file_line[1];
           
           $document->log_message = $matches[self::LOG_MESSAGE];
        
           foreach ($this->message_processors as $message_processor) {
               $message_processor->process($document);
           }
        }
    }
}