<?php

class Raggle_Scm_Git_Action_Log {

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
        $min_revision = null,
        $max_revision = null
    ) {
        $repo_dir = $this->root_dir . '/' . $repo->getName();
        $revision_range = '';
        if ($min_revision != null) {
            $revision_range = $min_revision . '..';
            if ($max_revision != null) {
                $revision_range .= $max_revision;
            }
        }
        $format = "\"{"
            . "'commit': '%H', "
            . "'author': {'name': '%aN', 'email': '%aE', 'date': '%at'}, "
            . "'committer': {'name': '%cN', 'email': '%cE', 'date': '%ct'}, "
            . "'message': '%s'"
            . "}\"";
            
        $this->exec->execute(
            "cd $repo_dir;"
            . "git log"
            . " --name-only"
            . " --pretty=format:$format"
            . " " . $revision_range,
            $output
        );
        return $output;
    }

}