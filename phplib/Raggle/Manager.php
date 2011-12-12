<?php

class Raggle_Manager {

    private $scm_manager;
    private $repository_manager;
    
    function __construct(
        Raggle_Scm_Manager $scm_manager,
        Raggle_Scm_Repository_Manager $repository_manager
    ) {
        $this->scm_manager = $scm_manager;
        $this->repository_manager = $repository_manager;
    }
    
    function getScm($scm_name) {
        return $this->scm_manager->getScm($scm_name);
    }
    
    function getRepository($repository_name) {
        return $this->repository_manager->getRepository($repository_name);
    }
}