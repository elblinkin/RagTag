<?php

class Raggle_Scm_Git_Action_GetHeadSha {

    private $root_dir;
    private $exec;
    
    function __construct(
        $root_dir,
        Raggle_Exec $exec
    ) {
        $this->root_dir = $root_dir;
        $this->exec = $exec;
    }
    
    function execute(
        Raggle_Scm_Repository_Git $repo,
        $output = null // DI for testing
    ) {
        $repo_dir = $this->root_dir . '/' . $repo->getName();
        $this->exec->execute("cd $repo_dir; git rev-parse --verify HEAD", $output);
        return $output[0];
    }
}