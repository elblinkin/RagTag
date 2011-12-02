<?php

class Raggle_Scm_Git_Action_Clean {

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
        Raggle_Scm_Repository_Git $repo
    ) {
        $repo_dir = $this->root_dir . '/' . $repo->getName();
        $this->exec->execute("cd $repo_dir; git clean -fdx");
    }
}