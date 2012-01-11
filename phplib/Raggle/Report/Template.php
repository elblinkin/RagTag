<?php

namespace Raggle\Report;

class Template {

    private $name;
    private $processor_map;
    
    function __construct(
        $name,
        array $processor_map
    ) {
        $this->name = $name;
        $this->processor_map = $processor_map;
    }
    
    function getName() {
        return $this->name;
    }
    
    function getReportFilenames() {
        return array_keys($this->processor_map);
    }
    
    function getProcessor($report) {
        return $this->processor_map[$report_filename];
    }
}