<?php

namespace Raggle\Printer;

class Gearman implements \Raggle\Printer {

    private $job;
    
    function __construct(\GearmanJob $job) {
        $this->job = $job;
    }
    
    function write($message) {
        $this->job->sendData($message);
    }
}