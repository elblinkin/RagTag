<?php

namespace Raggle\Scm\Git\Action;
use Raggle\Scm\Repository;
use RagTag\Executor;

class Checkout {

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
        $this->exec->execute("cd $repo_dir; git checkout -f");
        $branches = $repo->getBranches();
        if (!(is_null($branches) || empty($branches))) {
            $branch = $branches[0];
            $this->exec->execute("cd $repo_dir; git branch", $output);
            $pieces = explode(' ', $output[0]);
            if ($pieces[0] != '*') {
                throw new \InvalidArgumentException('First should be current');
            }
            if ($pieces[1] != $branch) {
                $this->exec->execute("cd $repo_dir; git checkout -b $branch");
            }
        }
    }
}
