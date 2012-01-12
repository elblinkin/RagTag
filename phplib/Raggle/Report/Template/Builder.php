<?php

namespace Raggle\Report\Template;

use Raggle\Report\Processor\Manager as ProcessorManager;

class Builder {

    private $processor_manager;
    
    private $name;
    private $processor_map;
    
    function __construct(ProcessorManager $processor_manager) {
        $this->processor_manager = $processor_manager;
        $this->processor_map = array();
    }
    
    function setName($name) {
        $this->name = $name;
        return $this;
    }
    
    function addProcessor($filename, $processor_name) {
        $processor = $this->processor_manager->getProcessor($processor_name);
        $this->processor_map[$filename] = $processor;
        return $this;
    }
    
    function build() {
        if (!isset($this->name)) {
            throw new UnexpectedValueException('$name must not be null');
        }
        
        $template = new Template(
            $this->name,
            $this->processor_map
        );
        
        unset($this->name);
        unset($this->processor_map);
        
        return $template;
    }
}