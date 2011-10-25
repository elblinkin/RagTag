<?php

class Taggle_PHP_Log_Processor_Level_Info implements Taggle_PHP_Log_Processor_Level {

    const INFO_REGEX = '@\[(.*)\] \[(.*)\] \[info\] \[(.*)\] \[(.*)\] (.*)@';
    
    const LOG_DATE = 1;
    const LOG_ID = 2;
    const LOG_NAMESPACE = 3;
    const FILE_LINE = 4;
    const INFO_MESSAGE = 5;
    
    function process($line, &$document) {
        if (preg_match(self::INFO_REGEX, $line, $matches)) {
            $document->log_date = $matches[self::LOG_DATE];
            $document->log_id = $matches[self::LOG_ID];
            $document->log_level = 'info';
            $document->log_namespace = $matches[self::LOG_NAMESPACE];
            $document->log_message = $matches[self::INFO_MESSAGE];
        }
    }
}