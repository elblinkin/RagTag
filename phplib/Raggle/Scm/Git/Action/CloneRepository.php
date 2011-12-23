<?php

namespace Raggle\Scm\Git\Action;
use Raggle\Executor;
use Raggle\Scm\Repository;

class CloneRepository {

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
        $url = $git->getUrl();
        if (file_exists($repo_dir)) {
            $this->exec->execute("rm -rf $repo_dir");
        }
        foreach($git->getBranches() as $branch) {
            $this->exec->execute(
                "git clone"
                . " -o origin"
                . " -b $branch"
                . " $url"
                . " $repo_dir"
            );
        }
    }
}
