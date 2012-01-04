<?php

namespace Raggle\Scm\Git\Action;
use Raggle\Scm\Repository;
use RagTag\Executor;

class Clean {

    private $root_dir;
    private $exec;
    
    function __construct(
        $root_dir,
        Executor $exec
    ) {
        $this->root_dir = $root_dir;
        $this->exec = $exec;
    }
    
    function execute(
        Repository\Git $repo
    ) {
        $repo_dir = $this->root_dir . '/' . $repo->getName();
        $this->exec->execute("cd $repo_dir; git clean -fdx");
    }
}
