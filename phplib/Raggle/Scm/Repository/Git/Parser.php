<?php

class Raggle_Scm_Repository_Git_Parser {

    private $builder;
    
    function __construct(Raggle_Scm_Repository_Git_Builder $builder) {
        $this->builder = $builder;
    }
    
    function parse($scm_json) {
        return $this->builder
            ->setName($scm_json->name)
            ->setUrl($scm_json->url)
            ->setBranches($scm_json->branches)
            ->build();
    }
}