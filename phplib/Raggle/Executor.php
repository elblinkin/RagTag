<?php

namespace Raggle;

class Executor {

    private $logger;
    
    function __construct(
        Logger $logger
    ) {
        $this->logger = $logger;
    }

    function execute($command, &$output = null, &$return_var = null) {
        $this->logger->logCommand($command);
        exec($command, $output, $return_var);
        $this->logger->logReturn($output, $return_var);
    }
}