<?php

class EtsyTaggle_PHP_Log_Processor implements Taggle_Document_Processor {

    private $level_processors;
    private $store;
    private $taggle_type;

    function __construct(
        array $level_processors,
        Taggle_Store $store,
        $taggle_type = 'php_log'
    ) {
        $this->level_processors = $level_processors;
        $this->store = $store;
        $this->taggle_type = $taggle_type;
    }
    
    function process($document, $ref_id=null) {
        $documents = array();
        $handle = fopen($document, 'r');
        while(($line = fgets($handle, 4096 * 3)) !== false) {
            $document = new StdClass;
            $document->raw = $line;
            $document->ref_id = $ref_id;
            $document->taggle_type = $this->taggle_type;
            
            foreach ($this->level_processors as $level_processor) {
                $level_processor->process($line, $document);
            }
            
            $documents[] = $document;
        }
        fclose($handle);
        return $this->store->batchSave($documents);
    }
}
