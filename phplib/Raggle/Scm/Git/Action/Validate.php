<?php

class Raggle_Scm_Git_Action_Validate {

    const FETCH_URL = "@Fetch URL: (\S+)@";
    const REMOTE_START = "@Remote branch(es)?:@";
    const BRANCH = "@(\S+)\s+tracked@";

    private $root_dir;
    private $exec;
    private $logger;
    
    function __construct(
        $root_dir,
        Raggle_Exec $exec,
        Raggle_Logger $logger
    ) {
        $this->root_dir = $root_dir;
        $this->exec = $exec;
        $this->logger = $logger;
    }
    
    function execute(
        Raggle_Scm_Repository_Git $git
    ) {
        $repo_dir = $this->root_dir . '/' . $git->getName();
        $this->exec->execute(
            "cd $repo_dir; git remote show origin",
            $output,
            $return_var
        );
        
        return $this->_execute($git, $output, $return_var);
    }
    
    function _execute(
        Raggle_Scm_Repository_Git $git,
        $output,
        $return_var
    ) {
        if ($return_var !== 0) {
            return false;
        }
        
        $is_remote_section = false;
        $branches = array();
        foreach ($output as $line) {
            if (preg_match(self::FETCH_URL, $line, $matches)) {
                if ($matches[1] !== $git->getUrl()) {
                    $url = $git->getUrl();
                    $this->logger->logError(
                        "Remote does not match, expected: $url"
                        . ", actual: $url"
                    );
                    return false;
                }
            } else if (preg_match(self::REMOTE_START, $line)) {
                $is_remote_section = true;
            } else if ($is_remote_section
                && preg_match(self::BRANCH, $line, $matches)
            ) {
                $branches[] = $matches[1];
            }
        }
        
        foreach ($git->getBranches() as $branch) {
            if (array_search($branch, $branches) === false) {
                $this->logger->logError(
                    "Repository does not contain branch: $branch"
                );
                return false;
            }
        }
        
        return true;
    }
}
