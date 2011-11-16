<?php

class Raggle_Exec {

    private $logger;
    
    function __construct(
        Raggle_Logger $logger
    ) {
        $this->logger = $logger;
    }

    function exec($command, &$output, &$return_var) {
        exec($command, $output, $return_var);
        $logger->logExec($command, $output, $return_var);
    }
}