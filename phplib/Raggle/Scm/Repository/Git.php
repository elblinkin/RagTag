<?php

namespace Raggle\Scm\Repository;

class Git implements \Raggle\Scm\Repository {

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