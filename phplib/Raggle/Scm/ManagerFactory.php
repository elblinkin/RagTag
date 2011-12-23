<?php

namespace Raggle\Scm;
use Raggle\Executor;
use Raggle\Logger;

class ManagerFactory {

    private $root_dir;
    private $exec;
    private $logger;
    
    private $scm_factories;
    
    function __construct(
        $root_dir,
        Executor $exec,
        Logger $logger,
        array $scm_factories
    ) {
        $this->root_dir = $root_dir;
        $this->exec = $exec;
        $this->logger = $logger;
        $this->scm_factories = $scm_factories;
    }
    
    function create() {
        $scm_map = array();
        foreach ($this->scm_factories as $scm_factory) {
            $scm = $scm_factory->create($this->root_dir, $this->exec, $this->logger);
            $name = $scm->getName();
            $scm_map[$name] = $scm;
        }
        return new Manager($scm_map);
    }
}