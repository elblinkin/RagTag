<?php

class Taggle_PHP_Log_Processor_Factory {

    private $store;
    
    function __construct(Taggle_Store $store) {
        $this->store = $store;
    }
    
    function create() {
        $dev_debug_processor = new Taggle_PHP_Log_Processor_Message_DevDebug();
        $stacktrace_processor = new Taggle_PHP_Log_Processor_Message_Stacktrace();
        $memcache_processor = new Taggle_PHP_Log_Processor_Message_Memcache();
        
        $info_processor = new Taggle_PHP_Log_Processor_Level_Info();
        $other_processor = new Taggle_PHP_Log_Processor_Level_Other(
            array(
                $dev_debug_processor,
                $stacktrace_processor,
                $memcache_processor,
            )
        );
        
        return new Taggle_PHP_Log_Processor(
            array(
                $info_processor,
                $other_processor,
            ),
            $this->store
        );
    }
}