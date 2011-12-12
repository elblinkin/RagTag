<?php

class Raggle_Scm_Repository_Git_Builder {

    private $name;
    private $url;
    private $branches;
    
    function setName($name) {
        $this->name = $name;
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
        if (!isset($this->url)) {
            throw new UnexpectedValueException('Must specify repository url');
        }
        if (!isset($this->branches) || empty($this->branches)) {
            throw new UnexpectedValueException('Must specify at least one branch');
        }
        
        $git = new Raggle_Scm_Repository_Git(
            $this->name,
            $this->url,
            $this->branches
        );
        
        unset($this->name);
        unset($this->url);
        unset($this->branches);
        
        return $git;
    }
}