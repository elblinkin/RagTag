<?php

class Raggle_Scm_Git_Action_Clone {

    private $root_dir;
    
    function __construct($root_dir) {
        $this->root_dir = $root_dir;
    }
    
    function execute(
        Raggle_Scm_Repository_Git $git,
        Raggle_Exec $exec
    ) {
        $repo_dir = $this->root_dir . '/' . $git->getName();
        if (file_exists($repo_dir)) {
            $exec->execute("rm -rf $repo_dir");
        }
        foreach($git->getBranches() as $branch) {
            $exec->execute(
                "git clone"
                . " -o origin"
                . " -b $branch"
                . " $git->getUrl()"
                . " $repo_dir"
            );
        }
    }
}
