<?php

namespace RagTag\Printer;

class Gearman implements \RagTag\Printer {

    private $job;
    
    function __construct(\GearmanJob $job) {
        $this->job = $job;
    }
    
    function write($message) {
        $this->job->sendData($message);
    }
}