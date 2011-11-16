<?php

class Raggle_Scm_Repository_Git {

    private $name;
    private $url;
    private $branches;
    
    function __construct(
        $name,
        $url,
        $branches
    ) {
        $this->name = $name;
        $this->url = $url;
        $this->branches = $branches;
    }
    
    function getName() {
        return $this->name;
    }
    
    function getUrl() {
        return $this->url;
    }
    
    function getBranches() {
        return $this->branches;
    }
}