<?php

namespace Raggle\Scm\Repository;

class ManagerFactory {
    
    function create(array $repositories) {
        $repository_map = array();
        foreach($repositories as $repository) {
            $repository_map[$repository->getName()] = $repository;
        }
        return new Manager($repository_map);
    }
}
