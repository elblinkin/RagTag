<?php

class Raggle_Exec {

    private $logger;
    
    function __construct(
        Raggle_Logger $logger
    ) {
        $this->logger = $logger;
    }

    function execute($command, &$output = null, &$return_var = null) {
        $this->logger->logCommand($command);
        exec($command, $output, $return_var);
        $this->logger->logReturn($output, $return_var);
    }
}