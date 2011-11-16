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
    
    }
}