<?php

namespace Raggle\Scm\Repository\Git;

use Raggle\Scm\Manager as ScmManager;
use UnexpectedValueException;

class Builder {

    private $scm_manager;
    
    private $name;
    private $scm;
    private $url;
    private $branches;
    
    function __construct(ScmManager $scm_manager) {
        $this->scm_manager = $scm_manager;
    }
    
    function setName($name) {
        $this->name = $name;
        return $this;
    }
    
    function setScm($type) {
        $this->scm = $this->scm_manager->getScm($type);
        return $this;
    }
    
    function setUrl($url) {
        $this->url = $url;
        return $this;
    }
    
    function setBranches(array $branches) {
        $this->branches = $branches;
        return $this;
    }
    
    function build() {
        if (!isset($this->name)) {
            throw new UnexpectedValueException('$name must not be null');
        }
        if (!isset($this->scm)) {
            throw new UnexpectedValueException('$scm must not be null');
        }
        if (!isset($this->url)) {
            throw new UnexpectedValueException('Must specify repository url');
        }
        if (!isset($this->branches) || empty($this->branches)) {
            throw new UnexpectedValueException('Must specify at least one branch');
        }
        
        $git = new \Raggle\Scm\Repository\Git(
            $this->name,
            $this->scm,
            $this->url,
            $this->branches
        );
        
        unset($this->name);
        unset($this->scm);
        unset($this->url);
        unset($this->branches);
        
        return $git;
    }
}