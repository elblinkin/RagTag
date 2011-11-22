<?php

class Raggle_Scm_Git_Action_Clone {

    private $root_dir;
    private $exec;
    
    function __construct(
        $root_dir,
        Raggle_Exec $exec
    ) {
        $this->root_dir = $root_dir;
        $this->exec = $exec;
    }
    
    function execute(Raggle_Scm_Repository_Git $git) {
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
