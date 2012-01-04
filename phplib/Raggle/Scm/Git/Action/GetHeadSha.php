<?php

namespace Raggle\Scm\Git\Action;
use Raggle\Scm\Repository;
use RagTag\Executor;

class GetHeadSha {

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
        Repository\Git $repo,
        $output = null // DI for testing
    ) {
        $repo_dir = $this->root_dir . '/' . $repo->getName();
        $this->exec->execute("cd $repo_dir; git rev-parse --verify HEAD", $output);
        return $output[0];
    }
}
