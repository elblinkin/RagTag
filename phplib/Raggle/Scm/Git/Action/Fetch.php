<?php

namespace Raggle\Scm\Git\Action;
use Raggle\Executor;
use Raggle\Scm\Repository;

class Fetch {

    private $root_dir;
    private $exec;
    
    function __construct(
        $root_dir,
        Executor $exec
    ) {
        $this->root_dir = $root_dir;
        $this->exec = $exec;
    }
    
    function execute(Repository\Git $git) {
        $repo_dir = $this->root_dir . '/' . $git->getName();
        $this->exec->execute("git fetch -t $repo_dir");
    }
}