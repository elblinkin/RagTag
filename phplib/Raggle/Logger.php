<?php 

namespace Raggle;

class Logger {

    private $printers;
    
    function __construct(array $printers) {
        $this->printers = $printers;
    }
    
    function logCommand($command) {
        $this->tee(sprintf(" + %s\n", $command));
    }

    function logReturn($output, $return_var) {
        foreach ($output as $line) {
            $this->tee(sprintf("\t%s\n", $line));
        }
        $this->tee(sprintf("\tReturn Value:  %s\n", $return_var));
    }
    
    function logInfo($message) {
        $this->tee(sprintf("[INFO] %s\n", $message));
    }
    
    function logError($message) {
        $this->tee(sprintf("[ERROR] %s\n", $message));
    }
    
    private function tee($message) {
        foreach ($this->printers as $printer) {
            $printer->write($message);
        }
    }
}