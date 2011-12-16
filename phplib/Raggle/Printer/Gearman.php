<?php

class Raggle_Printer_Gearman implements Raggle_Printer {

    private $job;
    
    function __construct(GearmanJob $job) {
        $this->job = $job;
    }
    
    function print($message) {
        $job->sendData($message);
    }
}