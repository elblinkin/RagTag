<?php

namespace Raggle\Scm\Repository\Git;

class Parser {

    private $builder;
    
    function __construct(Builder $builder) {
        $this->builder = $builder;
    }
    
    function parse($scm_json) {
        return $this->builder
            ->setName($scm_json->name)
            ->setScm($scm_json->scm)
            ->setUrl($scm_json->url)
            ->setBranches($scm_json->branches)
            ->build();
    }
}