<?php

namespace Raggle\Scm\Repository;

class Manager {

    private $repository_map;
    
    function __construct(array $repository_map) {
        $this->repository_map = $repository_map;
    }
    
    function getRepository($repository_name) {
        return $this->repository_map[$repository_name];
    }
}