<?php

class Raggle_Logger {

    function logCommand($command) {
        printf(" + %s\n", $command);
    }

    function logReturn($output, $return_var) {
        foreach ($output as $line) {
            printf ("\t%s\n", $line);
        }
        // TODO Implement logging
    }
    
    function logInfo($message) {
        printf("%s\n", $message);
        // TODO Implement logging
    }
    
    function logError($message) {
        printf("%s\n", $message);
        // TODO Implement logging
    }
}