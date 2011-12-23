<?php

namespace Raggle\Scm;

class Manager {

    private $scm_map;
    
    function __construct(array $scm_map) {
        $this->scm_map = $scm_map;
    }
    
    function getScm($scm_name) {
        return $this->scm_map[$scm_name];
    }
}