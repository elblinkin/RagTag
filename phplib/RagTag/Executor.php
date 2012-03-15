<?php

namespace RagTag;

class Executor {

    private $logger;
    
    function __construct(
        Logger $logger
    ) {
        $this->logger = $logger;
    }

    function execute($command, &$output = null, &$return_var = null) {
        exec("echo '$command' | bash -x 2>&1", $output, $return_var);
        $this->logger->logCommand($output, $return_var);
    }
}