<?php

class Raggle_Scm_Git_Action_Fetch {

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
        $this->exec->execute("git fetch -t $repo_dir");
    }
}